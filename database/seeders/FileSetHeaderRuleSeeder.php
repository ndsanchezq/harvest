<?php

namespace Database\Seeders;

use App\Models\FileSetHeaderRule;
use Illuminate\Database\Seeder;

class FileSetHeaderRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileSetHeaderRule::insert([
            'register_type_value' => '05',
            'register_type_lenght' => 2,
            'invoiced_service_code_value' => '0000830053700',
            'invoiced_service_code_lenght' => 13,
            'lot_number_value' => '0001',
            'lot_number_lenght' => 4,
            'invoiced_service_description_value' => 'PATRIMONIOS AUT',
            'invoiced_service_description_length' => 15,
            'reserved_white_spaces' => 186,
            'bank_id' => 4
        ]);
    }
}
