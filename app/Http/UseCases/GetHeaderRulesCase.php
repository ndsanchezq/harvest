<?php

namespace App\Http\UseCases;

use App\Models\FileHeaderRule;
use App\Models\FileSetHeaderRule;
use Illuminate\Support\Facades\Log;

class GetHeaderRulesCase
{
    public static function index($set_number = '----', $modifier = '-')
    {
        // Validations
        $headerRules = FileHeaderRule::where('bank_id', 4)->first();
        if (!$headerRules instanceof FileHeaderRule) {
            Log::error('No fue posible recuperar el encabezado del archivo');
            return;
        }

        $headerLotRules = FileSetHeaderRule::where('bank_id', 4)->first();
        if (!$headerLotRules instanceof FileSetHeaderRule) {
            Log::error('No fue posible recuperar el encabezado de lote del archivo');
            return;
        }

        // Header file
        $content = implode([
            $headerRules->register_type_value,
            $headerRules->did_main_collector_company_value,
            $headerRules->did_additional_collector_company_value,
            $headerRules->financial_entity_code_value,
            now()->format('YmdHi'),
            $modifier,
            str_repeat(' ', $headerRules->reserved_white_spaces),
            "\n"
        ]);

        // Header lot
        $content .= implode([
            $headerLotRules->register_type_value,
            $headerLotRules->invoiced_service_code_value,
            $set_number,
            $headerLotRules->invoiced_service_description_value,
            str_repeat(' ', $headerLotRules->reserved_white_spaces),
            "\n"
        ]);

        return [$headerRules, $headerLotRules, $content];
    }
}
