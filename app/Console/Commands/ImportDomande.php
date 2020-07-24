<?php

namespace App\Console\Commands;

use App\Models\Domanda;
use Illuminate\Console\Command;

class ImportDomande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:domande';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa le domande dal file di configurazione .opis e cancella le precedenti';

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
     * @return mixed
     */
    public function handle()
    {
        Domanda::truncate(); 

        $this->callSilent('db:seed', ['--class' => 'StandardWeightSeeder']);
        $this->info('Domande importate correttamente'); 
    }
}
