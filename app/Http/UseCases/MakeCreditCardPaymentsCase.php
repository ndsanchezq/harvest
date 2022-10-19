<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;

class MakeCreditCardPaymentsCase
{
    public static function index()
    {
        $deferred_payments = AgreementLineDeferredPayment::query()
            ->active()->mercadoPago();

        foreach ($deferred_payments->cursor() as $deferred_payment) {
            $deferred_payment->load('customer');
            $deferred_payment->load(['agreementLines' => function ($q) {
                $q->with(['paymentMethod', 'agreement', 'product']);
            }]);
            $response = FetchMercadoPagoCustomerCase::index($deferred_payment->customer);
            if ($response['status'] == 'success') {
                print_r($deferred_payment->customer->email . ' Brand ' . $deferred_payment->customer->brand_id . ' >> ' . $response['customer_id'] . PHP_EOL);
                MakeMercadoPagoPaymentCase::index($deferred_payment, $response['customer_id']);
            } else {
                print_r($response['message'] . PHP_EOL);
            }
        }
    }
}
