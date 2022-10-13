<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use Illuminate\Support\Facades\Storage;

class GenerateCashingFileCase
{
    /**
     * Generate cashing file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function index()
    {
        $today = now()->format('Y-m-d');
        $bancolombia_deferred_payments = AgreementLineDeferredPayment::query()->active()->debito()->bancolombia();

        if ($bancolombia_deferred_payments->count() < 1) {
            echo "No hay pagos pendientes para cuentas Bancolombia";
            return false;
        }

        // Registro de encabezado del archivo y registro de encabezado del lote
        [$headerRules, $headerLotRules, $bancolombia_content_file] = GetHeaderRulesCase::index();

        // generar registro del detalle
        [$bancolombia_content_file, $bancolombia_total_register] = GenerateCashingRegisterDetailCase::index($bancolombia_deferred_payments);

        // generar registro de control de lote y de archivo
        $bancolombia_content_file .= GenerateCashingRegisterControlCase::index($bancolombia_deferred_payments);

        Storage::put('/BANCOLOMBIA/' . $today . '_BANCOLOMBIA_COBROS', $bancolombia_content_file);

        return true;
    }
}
