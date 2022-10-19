<?php

namespace App\Http\UseCases;

class GetCardTokenCase
{
    public static function index($card_id, $token, $public_key)
    {
        $curl = curl_init();
        $payload = [
            "card_id" => $card_id
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('MERCADO_PAGO_API_URL') . '/card_tokens?public_key=' . $public_key,
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
            return null;
        }

        return isset(json_decode($curl_response)->id) ? json_decode($curl_response)->id : null;
    }
}
