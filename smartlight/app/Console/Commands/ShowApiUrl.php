<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class ShowApiUrl extends Command
{
    protected $signature = 'api:url';
    protected $description = 'Show the API URLs';

    public function handle()
    {
        $this->info('API URLs:');
        $this->line('GET Light Status: ' . url('/api/light/status'));
        $this->line('POST Update Status: ' . url('/api/light/status'));
        $this->line('POST Toggle: ' . url('/api/light/toggle'));
        $this->line('POST Set Mode: ' . url('/api/light/mode'));
        $this->line('');
        $this->info('Current base URL: ' . URL::to('/'));
        
        return Command::SUCCESS;
    }
}
