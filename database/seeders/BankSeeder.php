<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::insert([
            ['name' => 'BANCO DE BOGOTÁ', 'did' => '8600029644'],
            ['name' => 'BANCO POPULAR S.A.', 'did' => '8600077389'],
            ['name' => 'BANCO ITAÚ S.A.', 'did' => '8909039370'],
            ['name' => 'BANCOLOMBIA S.A.', 'did' => '8909039388'],
            ['name' => 'CITIBANK', 'did' => '8600511354'],
            ['name' => 'BANCO GNB SUDAMERIS S.A.', 'did' => '8600507501'],
            ['name' => 'BANCO  DE  OCCIDENTE S.A.', 'did' => '8903002794'],
            ['name' => 'BANCO BBVA COLOMBIA.', 'did' => '8600030201'],
            ['name' => 'BANCO CAJA SOCIAL S.A.', 'did' => '8600073354'],
            ['name' => 'BANCO DAVIVIENDA S.A.', 'did' => '8600343137'],
            ['name' => 'COLPATRIA', 'did' => NULL],
            ['name' => 'BANCO AGRARIO', 'did' => NULL],
            ['name' => 'AV VILLAS', 'did' => NULL],
            ['name' => 'COOMEVA', 'did' => NULL],
            ['name' => 'Banco Multibank S.A.', 'did' => NULL],
            ['name' => 'BANCO COOPERATIVO COOPCENTRAL', 'did' => NULL],
            ['name' => 'Financiera Juriscoop S.A.', 'did' => NULL],
        ]);
    }
}
