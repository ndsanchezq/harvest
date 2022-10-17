<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use App\Models\MyBodyTech\Invoice;
use App\Models\MyBodyTech\Payment;

class GeneratePaymentCase
{
    public static function index(AgreementLineDeferredPayment $deferred_payment, Invoice $invoice, int $payment_type_id)
    {
        $today = now()->format('Y-m-d H:i:s');
        $payment = new Payment();
        $payment->payment_date = $today;
        $payment->amount = $deferred_payment->amount;
        $payment->payment_type_id = $payment_type_id;
        $payment->num_payment = 1;
        $payment->status = 1;
        $payment->users_creator = 2661; //cambiar a usuario debito automatico
        $payment->create_at = $today;
        $payment->invoice_id = $invoice->id;
        $payment->create_at_db = $today;
        $payment->agreement_lines_id = $deferred_payment->agreementLines->id;
        $payment->agreement_id = $deferred_payment->agreementLines->agreement->id;
        $payment->payment_status = 2;
        $payment->brand_id = $deferred_payment->agreementLines->agreement->brand_id;
        $payment->payment_method_id = $deferred_payment->agreementLines->paymentMethod->id;
        $payment->transaction_method = 2;
        $payment->bank_id = $deferred_payment->agreementLines->paymentMethod->banks_id;
        $payment->save();

        return $payment;
    }
}
