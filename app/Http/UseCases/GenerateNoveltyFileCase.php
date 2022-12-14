<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
use App\Models\MyBodyTech\PaymentMethod;
use App\Http\UseCases\StoreFileCase;
use App\Models\File;
use PhpParser\Node\Stmt\For_;

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
    public static function index()
    {
        $today = now()->format('Y-m-d');
        $files_number = File::where('created_at', '>=', $today)->where('received', 0)->get()->count();
        $set_number = FormatString::fill($files_number + 1, '0', 4);
        $modifier = 'C';
        $file_type = 'novedad';
        $bancolombia_payment_methods = PaymentMethod::query()->accountsForValidating()->bancolombia()->take(10000);
        $other_banks_payment_methods = PaymentMethod::query()->accountsForValidating()->otherBanks()->take(10000);

        /**Generar Novedades para cuentas bancolombia */
        if ($bancolombia_payment_methods->count() < 1) {
            echo "No se genero archivo novedades para cuentas Bancolombia" . PHP_EOL;
        } else {
            // Registro de encabezado del archivo y registro de encabezado del lote
            [$headerRules, $headerLotRules, $bancolombia_content_file] = GetHeaderRulesCase::index($set_number, $modifier, 'novelty');

            // Registro de detalle
            [$bancolombia_register_detail, $bancolombia_total_register] = self::generateDetailRegister($bancolombia_payment_methods);
            $bancolombia_content_file .= $bancolombia_register_detail;

            // Registro de control del lote y registro de control del archivo
            $bancolombia_content_file .= NoveltyControlRegisterCase::generate($bancolombia_total_register, $set_number);

            // Store file
            $file_name = $today . '_BANCOLOMBIA_NOVEDADES.txt';
            $path = 'BANCOLOMBIA/' . $file_name;
            StoreFileCase::index($file_name, $path, $bancolombia_content_file, $modifier, $bancolombia_total_register + 4, $file_type);
            $set_number = FormatString::fill($files_number + 2, '0', 4);
        }

        $modifier = 'D';
        /**Generar Novedades para cuentas otros bancos */
        if ($other_banks_payment_methods->count() < 1) {
            echo "No se genero archivo novedades para cuentas ACH" . PHP_EOL;
        } else {
            // Registro de encabezado del archivo y registro de encabezado del lote
            [$headerRules, $headerLotRules, $other_banks_content_file] = GetHeaderRulesCase::index($set_number, $modifier, 'novelty');

            // Registro de detalle
            [$other_banks_register_detail, $other_banks_total_register] = self::generateDetailRegister($other_banks_payment_methods);
            $other_banks_content_file .= $other_banks_register_detail;

            // Registro de control del lote y registro de control del archivo
            $other_banks_content_file .= NoveltyControlRegisterCase::generate($other_banks_total_register, $set_number);

            // Store file
            $file_name = $today . '_ACH_NOVEDADES.txt';
            $path = 'BANCOLOMBIA/' . $file_name;
            StoreFileCase::index($file_name, $path, $other_banks_content_file, $modifier, $other_banks_total_register + 4, $file_type);
        }

        return true;
    }

    private function generateDetailRegister($payment_methods)
    {
        $content = '';
        $counter = 0;
        foreach ($payment_methods->cursor() as $payment_method) {
            $full_name = FormatString::removeAccents($payment_method->customer->first_name . ' ' . $payment_method->customer->last_name);
            $payment_method->load('customer');
            $primary_ref = FormatString::fill($payment_method->id, '0', 48);
            $secondary_ref = FormatString::fill($payment_method->customer->id, '0', 24) . str_repeat(' ', 6);
            $account_number = FormatString::fill($payment_method->account, '0', 17);
            $account_type = FormatString::fill($payment_method->account_type, '0', 2);
            $customer_did = FormatString::fill($payment_method->customer->did, '0', 10);
            $customer_name = FormatString::fill(strtoupper($full_name), ' ', 22, true);
            $max_value = str_repeat('0', 14);
            $transaction_date = now()->format('Ymd');
            $sequence = FormatString::fill($counter + 1, '0', 7);
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

            // payment_method_validation_status = 'en proceso'
            $payment_method->payment_method_validation_status = 2;
            $payment_method->payment_method_validation_date = now()->format('Y-m-d');
            $payment_method->save();
        }

        return [$content, $counter];
    }
}
