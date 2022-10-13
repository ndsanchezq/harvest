<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
use App\Models\MyBodyTech\PaymentMethod;

class GenerateNoveltyFileCase
{
    const EFR = '00001007';
    const REGISTER_TYPE = '06';
    const REGISTER_TYPE_CODE = '23';
    /**
     * generate novelty file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public function index()
    {
        $bancolombia_payment_methods = PaymentMethod::query()->accountsForValidating()->bancolombia()->take(10);

        // Registro de encabezado del archivo y registro de encabezado del lote
        [$headerRules, $headerLotRules, $content] = GetHeaderRulesCase::index();

        // Registro de detalle
        [$register_detail, $bancolombia_total_register] = $this->generateDetailRegister($bancolombia_payment_methods);
        $content .= $register_detail;

        // Registro de control del lote y registro de control del archivo
        $content .= NoveltyControlRegisterCase::generate($bancolombia_total_register, '0001');


        return \Storage::put('BANCOLOMBIA_NOVEDADES.txt', $content);

        echo 'Archivo generado';
    }

    private function generateDetailRegister($payment_methods)
    {
        $content = '';
        $counter = 1;
        foreach ($payment_methods->cursor() as $payment_method) {
            $payment_method->load('customer');
            $primary_ref = FormatString::fill($payment_method->customer->did, '0', 48);
            $secondary_ref = FormatString::fill($payment_method->id, '0', 24) . str_repeat(' ', 6);
            $account_number = FormatString::fill($payment_method->account, '0', 17);
            $account_type = FormatString::fill($payment_method->account_type, '0', 2);
            $customer_did = FormatString::fill($payment_method->customer->did, '0', 10);
            $customer_name = FormatString::fill(strtoupper($payment_method->customer->first_name . ' ' . $payment_method->customer->last_name), ' ', 22, true);
            $max_value = str_repeat('0', 14);
            $transaction_date = now()->format('Ymd');
            $sequence = FormatString::fill($counter, '0', 7);
            $response_code = str_repeat(' ', 3);
            $debit_programming_start_date = now()->format('dmY');
            $debit_programming_end_date = str_repeat(' ', 8);
            $retry_days = str_repeat('0', 2);
            $apply_criteria = '01';
            $pay_frecuency = '01';
            $days_number = str_repeat(' ', 3);
            $pay_day = '01';
            $partial_debit = '002';
            $reserved_white_spaces = str_repeat(' ', 17);
            $content .=
                self::REGISTER_TYPE
                . self::REGISTER_TYPE_CODE
                . $primary_ref
                . $secondary_ref
                . self::EFR
                . $account_number
                . $account_type
                . $customer_did
                . $customer_name
                . $max_value
                . $transaction_date
                . $sequence
                . $response_code
                . $debit_programming_start_date
                . $debit_programming_end_date
                . $retry_days
                . $apply_criteria
                . $pay_frecuency
                . $days_number
                . $pay_day
                . $partial_debit
                . $reserved_white_spaces
                . "\n";

            $counter++;
        }

        return [$content, $counter];
    }
}
