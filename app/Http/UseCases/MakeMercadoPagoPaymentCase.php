<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use Illuminate\Support\Facades\Log;

class MakeMercadoPagoPaymentCase
{
    public static function index(AgreementLineDeferredPayment $deferred_payment, string $customer_id)
    {

        try {
            //code...

            $ref_external = $deferred_payment->agreementLines->paymentMethod->ref_external;
            $payment_method_id = $deferred_payment->agreementLines->paymentMethod->id;

            // if (empty($ref_external)) {
            //     $message = 'Campo ref_external vacio en metodo de pago con id ' . $payment_method_id . PHP_EOL;
            //     echo $message;
            //     Log::error($message);
            //     return;
            // }

            $payload = [
                "binary_mode" => true,
                "description" => "Cobro debito automatico",
                // "external_reference" => $ref_external, // ref_external de metodo de pago
                "installments" => 1,
                "payer" => [
                    "entity_type" => "individual",
                    "id" => $customer_id, // id customer mercado pago
                    "type" => "customer"
                ],
                "processing_mode" => "aggregator",
                "token" => $ref_external, // token_credit_card
                "transaction_amount" => 1000 // valor a cobrar
            ];

            // Se genera una factura en draft para asignarsela al payment
            $invoice = GenerateDraftInvoice::index($deferred_payment);

            // Genera un registro de pago que sera actualizado con la respuesta del api de mercado pago
            $payment = GeneratePaymentCase::index($deferred_payment, $invoice, 1);

            // consume la api de Mercado Pago
            $token = $deferred_payment->customer->brand_id == 2 ? env('ATHLETIC_TOKEN_MERCADO_PAGO') : env('BODYTECH_TOKEN_MERCADO_PAGO');
            $curl = curl_init();
            $message = '';
            $data = null;
            $status = 'error';

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('MERCADO_PAGO_API_PAYMENT_URL'),
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

            if ($err) {
                echo "cURL Error #:" . $err;
                $message = $err;
            } else {
                echo 'cURL success' . PHP_EOL;
                $response = json_decode($curl_response);
                print_r($response);
                if ($response->status == 'approved') {
                    $status = 'success';
                    $data = $response;
                    // actualizar estados del pago
                    $deferred_payment->status = 1;
                    $deferred_payment->payment_status = 1;
                    $deferred_payment->save();
                    $payment->status = 1;
                    $payment->payment_status = 1;
                    $payment->save();
                } else {
                    // actualizar estados del pago
                    $deferred_payment->status = 1;
                    $deferred_payment->payment_status = 0;
                    $deferred_payment->save();
                    $payment->status = 1;
                    $payment->payment_status = 5; //rechazado
                    $payment->payment_reason_rejection = $response->status_detail ?? substr($response->description, 99) ?? 'Desconocido';
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
