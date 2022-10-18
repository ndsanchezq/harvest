<?php

namespace Database\Seeders;

use App\Models\FileHeaderRule;
use Illuminate\Database\Seeder;

class FileHeaderRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileHeaderRule::insert([
            'register_type_value' => '01',
            'register_type_lenght' => 2,
            'did_main_collector_company_value' => '0830053700',
            'did_main_collector_company_lenght' => 10,
            'did_additional_collector_company_value' => 'PATRIMONIOS AUTO',
            'did_additional_collector_company_lenght' => 16,
            'financial_entity_code_value' => '007',
            'financial_entity_code_length' => 3,
            'reserved_white_spaces' => 182,
            'bank_id' => 4
        ]);
    }
}
