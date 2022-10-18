<?php

namespace App\Console\Commands;

use App\Http\UseCases\MakeCreditCardPaymentsCase;
use Illuminate\Console\Command;

class PayMercadoPago extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mercado:pago';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realizar debitos automaticos a traves de mercado pago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MakeCreditCardPaymentsCase::index();
    }
}
