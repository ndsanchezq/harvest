<?php

namespace App\Http\UseCases;

use Illuminate\Support\Facades\Log;

class GenerateMyBodytechToken
{
    public static function index($brand_id)
    {
        if (empty($brand_id)) {
            $message =  'Especifique un brand para generar token my bodytech';
            Log::error($message);
            return null;
        }

        $client_id = $brand_id == 2 ? env('ATHLETIC_CLIENT_ID') : env('BODYTECH_CLIENT_ID');
        $client_secret = $brand_id == 2 ? env('ATHLETIC_CLIENT_SECRET') : env('BODYTECH_CLIENT_SECRET');

        $curl = curl_init();
        $payload = [
            "grant_type" => "client_credentials",
            "client_id" => $client_id,
            "client_secret" => $client_secret
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('OAUTH_MY_BODYTECH_API_URL') . '/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $curl_response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            $message = 'Error generando token my bodytech con brand ' . $brand_id . '. Error >>> ' . $err;
            Log::error($message);
            return null;
        }

        $response = json_decode($curl_response);

        if (isset($response->access_token)) {
            $mesagge = 'Token my bodytech en brand ' . $brand_id . ' generado con exito!';
            Log::info($mesagge);
            return $response->access_token;
        }

        $message = 'Error generando generando token my bodytech con brand ' . $brand_id . ' .Error >>> ' . json_encode($response->message);
        Log::error($message);

        return null;
    }
}
