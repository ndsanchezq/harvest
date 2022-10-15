<?php

namespace App\Http\UseCases;

use App\Http\UseCases\StoreFileCase;
use App\Models\MyBodyTech\AgreementLineDeferredPayment;

class GenerateCashingFileCase
{
    /**
     * Generate cashing file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function index()
    {
        $modifier = 'A';
        $set_number = '0001';
        $file_type = 'cobro';
        $today = now()->format('Y-m-d');
        $bancolombia_deferred_payments = AgreementLineDeferredPayment::query()->active()->debito()->bancolombia();
        $other_banks_deferred_payments = AgreementLineDeferredPayment::query()->active()->debito()->otherBanks();

        /**Generar pagos para cuentas Bancolombia */
        if ($bancolombia_deferred_payments->count() < 1) {
            echo "No hay pagos pendientes para cuentas Bancolombia";
        } else {
            // Registro de encabezado del archivo y registro de encabezado del lote
            [$headerRules, $headerLotRules, $bancolombia_content_file] = GetHeaderRulesCase::index($set_number, $modifier);

            // generar registro del detalle
            [$register_detail_content, $bancolombia_total_register] = GenerateCashingRegisterDetailCase::index($bancolombia_deferred_payments);
            $bancolombia_content_file .= $register_detail_content;

            // generar registro de control de lote y de archivo
            $bancolombia_content_file .= GenerateCashingRegisterControlCase::index($bancolombia_deferred_payments);

            $file_name = $today . '_BANCOLOMBIA_COBROS.txt';
            $path = 'BANCOLOMBIA/' . $file_name;
            StoreFileCase::index($file_name, $path, $bancolombia_content_file, $modifier, $bancolombia_total_register + 4, $file_type);
        }

        /**Generar pagos para cuentas otros bancos */
        echo $other_banks_deferred_payments->count();
        $modifier = 'B';
        $set_number = '0002';
        if ($other_banks_deferred_payments->count() < 1) {
            echo "No hay pagos pendientes para cuentas ACH";
        } else {
            // Registro de encabezado del archivo y registro de encabezado del lote
            [$headerRules, $headerLotRules, $other_banks_content_file] = GetHeaderRulesCase::index($set_number, $modifier);

            // generar registro del detalle
            [$register_detail_content, $other_banks_total_register] = GenerateCashingRegisterDetailCase::index($other_banks_deferred_payments);
            $other_banks_content_file .= $register_detail_content;

            echo $other_banks_total_register;

            // generar registro de control de lote y de archivo
            $other_banks_content_file .= GenerateCashingRegisterControlCase::index($other_banks_deferred_payments);

            $file_name = $today . '_ACH_COBROS.txt';
            $path = 'BANCOLOMBIA/' . $file_name;
            StoreFileCase::index($file_name, $path, $other_banks_content_file, $modifier, $other_banks_total_register + 4, $file_type);
        }

        return true;
    }
}
