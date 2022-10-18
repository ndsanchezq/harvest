<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\Customer;

class FetchMercadoPagoCustomerCase
{
    public static function index(Customer $customer)
    {
        $token = $customer->brand_id == 2 ? env('ATHLETIC_TOKEN_MERCADO_PAGO') : env('BODYTECH_TOKEN_MERCADO_PAGO');
        $curl = curl_init();
        $customer_id = '';
        $message = '';
        $status = 'error';

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SEARCH_CUSTOMER_MERCADO_PAGO_URL') . '?email=' . 'omaldo@hotmail.com',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            $message = $err;
        } else {
            if (isset(json_decode($response)->results[0]->id)) {
                $customer_id = json_decode($response)->results[0]->id;
                $status = 'success';
            } else {
                $message = '>>> Error: No se encontro el customer de mercado pago con el email '
                    . $customer->email . ' en la brand ' . $customer->brand_id;
            }
        }

        return [
            'status' => $status,
            'message' => $message,
            'customer_id' => $customer_id
        ];
    }
}
