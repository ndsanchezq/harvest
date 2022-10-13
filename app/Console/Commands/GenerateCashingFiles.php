<?php

namespace App\Console\Commands;

use App\Http\UseCases\CashingFileCase;
use Illuminate\Console\Command;

class GenerateCashingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:cashing:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar archivos de cobro cuentas debito';

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
        CashingFileCase::generate();
    }
}
