<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use App\Http\UseCases\GenerateMyBodytechToken;

class MakeCreditCardPaymentsCase
{
    public static function index()
    {
        $deferred_payments = AgreementLineDeferredPayment::query()
            ->active()->mercadoPago();

        $bodytech_token = GenerateMyBodytechToken::index(1);
        $athletic_token = GenerateMyBodytechToken::index(2);

        foreach ($deferred_payments->cursor() as $deferred_payment) {
            $my_bodytech_token = $deferred_payment->customer->brand_id == 2 ? $athletic_token : $bodytech_token;
            $deferred_payment->load('customer');
            $deferred_payment->load(['agreementLines' => function ($q) {
                $q->with(['paymentMethod', 'agreement', 'product']);
            }]);
            $response = FetchMercadoPagoCustomerCase::index($deferred_payment->customer);

            if ($response['status'] == 'success') {
                print_r($deferred_payment->customer->email . ' Brand ' . $deferred_payment->customer->brand_id . ' >> ' . $response['customer_id'] . PHP_EOL);
                MakeMercadoPagoPaymentCase::index($deferred_payment, $response['customer_id'], $my_bodytech_token);
            } else {
                print_r($response['message'] . PHP_EOL);
            }
        }
    }
}
