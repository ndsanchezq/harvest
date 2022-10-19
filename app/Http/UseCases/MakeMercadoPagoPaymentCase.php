<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use Illuminate\Support\Facades\Log;

class MakeMercadoPagoPaymentCase
{
    public static function index(AgreementLineDeferredPayment $deferred_payment, string $customer_id, $my_bodytech_token)
    {

        try {
            //prepara los tokens de acceso para mercado pago
            $token = $deferred_payment->customer->brand_id == 2 ? env('ATHLETIC_TOKEN_MERCADO_PAGO') : env('BODYTECH_TOKEN_MERCADO_PAGO');
            $public_key = $deferred_payment->customer->brand_id == 2 ? env('PUBLIC_KEY_ATHLETIC') : env('PUBLIC_KEY_BODYTECH');
            $card_id = $deferred_payment->agreementLines->paymentMethod->token_credit_card;
            $payment_method_id = $deferred_payment->agreementLines->paymentMethod->id;

            $card_token = GetCardTokenCase::index($card_id, $token, $public_key);

            if (empty($card_token)) {
                $message = 'No se pudo obtener el card token para el deferred payment ' . $deferred_payment->id;
                Log::error($message);
                return;
            }

            echo 'Card token: ' . $card_token . PHP_EOL;
            echo 'public key: ' . $public_key . PHP_EOL;
            // return;

            $payload = [
                "binary_mode" => true,
                "description" => "Cobro debito automatico",
                "external_reference" => $card_token, // $card_token de metodo de pago
                "installments" => 1,
                "payer" => [
                    "entity_type" => "individual",
                    "id" => $customer_id, // id customer mercado pago
                    "type" => "customer"
                ],
                "processing_mode" => "aggregator",
                "token" => $card_token, // card_token credit_card
                "transaction_amount" => $deferred_payment->amount // valor a cobrar
            ];

            // Se genera una factura en draft para asignarsela al payment
            $invoice = GenerateDraftInvoice::index($deferred_payment);

            // Genera un registro de pago que sera actualizado con la respuesta del api de mercado pago
            $payment = GeneratePaymentCase::index($deferred_payment, $invoice, 1);

            // consume la api de Mercado Pago
            $curl = curl_init();
            $message = '';
            $data = null;
            $status = 'error';

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('MERCADO_PAGO_API_URL') . '/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json'
                ),
            ));

            $curl_response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if (false) {
                echo "cURL Error #:" . $err;
                $message = $err;
            } else {
                echo 'cURL success' . PHP_EOL;
                $response = json_decode($curl_response);
                print_r($response);
                if (true) {
                    Log::info('Success, pago realizado!');
                    $status = 'success';
                    $data = $response;
                    // actualizar estados del pago
                    $deferred_payment->status = 1;
                    $deferred_payment->payment_status = 1;
                    $deferred_payment->save();
                    $payment->status = 1;
                    $payment->payment_status = 1;
                    $payment->save();
                    GenerateElectronicInvoice::index($invoice->id, $my_bodytech_token, $deferred_payment->customer->brand_id);
                } else {
                    // actualizar estados del pago
                    $deferred_payment->status = 1;
                    $deferred_payment->payment_status = 0;
                    $deferred_payment->save();
                    $payment->status = 1;
                    $payment->payment_status = 5; //rechazado
                    $payment->payment_reason_rejection = $response->status_detail ?? substr($response->message, 99) ?? 'Desconocido';
                    $payment->save();
                    $message = '>>> Error: realizando el pago recurrente No. '
                        . $deferred_payment->id . ' con metodo de pago No. '
                        . $payment_method_id . '. ' . $response->message . PHP_EOL;
                    echo $message;
                    Log::error($message);
                }
            }

            return [
                'status' => $status,
                'message' => $message,
                'data' => $data
            ];
        } catch (\Exception $ex) {
            echo $ex->getMessage() . 'on Line ' . $ex->getLine();
        }
    }
}
