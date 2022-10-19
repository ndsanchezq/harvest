<?php

namespace App\Http\UseCases;

use Illuminate\Support\Facades\Log;

class GenerateElectronicInvoice
{
    public static function index($invoice_id, $token, $brand_id)
    {
        try {
            echo 'Generando factura' . PHP_EOL;
            if (empty($invoice_id)) {
                echo 'Id factura vacio';
            }

            $curl = curl_init();
            $payload = [
                "id_invoice" => $invoice_id
            ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('PRODUCTS_MY_BODYTECH_API_URL') . '/invoices/generate-invoice-electronic',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                    'x-bodytech-organization: 1',
                    'x-bodytech-brand: ' . $brand_id
                ),
            ));

            $curl_response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);


            if ($err) {
                echo "cURL Error #:" . $err;
                $message = 'Error generando la factura numero ' . $invoice_id . '. Error >>> ' . $err;
                Log::error($message);

                return null;
            }

            if (str_contains($curl_response, 'success')) {
                $message = 'Factura numero ' . $invoice_id . ' generada con exito!';
                Log::info($message);
                Log::info($curl_response);

                return $message;
            }

            $message = 'Error generando la factura numero ' . $invoice_id . '. Error >>>> '; // json_encode($response->message);
            Log::error($message);

            return false;
        } catch (\Exception $ex) {
            echo $ex->getMessage() . 'on file ' . $ex->getFile() . ' line ' . $ex->getLine();
        }
    }
}
