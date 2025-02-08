<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunCustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-command {cmd}';
    protected $description = 'Executa um comando Artisan dentro da aplicação';

    public function handle()
    {
        $cmd = $this->argument('cmd');
        $this->info("Executando: php artisan {$cmd}");
        Artisan::call($cmd);
        $this->info(Artisan::output());
    }
}
