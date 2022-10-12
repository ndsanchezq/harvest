<?php

namespace App\Http\UseCases;

use App\Models\FileHeaderRule;
use App\Models\FileLotHeaderRule;

class GenerateNoveltyFileCase
{

    /**
     * generate novelty file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public function index()
    {
        // Validations
        $headerRules = FileHeaderRule::where('bank_id', 4)->first();
        if (!$headerRules instanceof FileHeaderRule) {
            Log::error('No fue posible recuperar el encabezado del archivo');
        }

        $headerLotRules = FileLotHeaderRule::where('bank_id', 4)->first();
        if (!$headerLotRules instanceof FileLotHeaderRule) {
            Log::error('No fue posible recuperar el encabezado de lote del archivo');
        }

        // Header file
        $content = implode([
            $headerRules->register_type_value,
            $headerRules->did_main_collector_company_value,
            $headerRules->did_additional_collector_company_value,
            $headerRules->financial_entity_code_value,
            now()->format('YmdHi'),
            'A',
            str_repeat(' ', $headerRules->reserved_white_spaces),
            "\n"
        ]);
    }
}
