<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:dev {--host=127.0.0.1} {--port=8000} {--reverb-port=8081}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start development environment with Laravel serve and Reverb';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $reverbPort = $this->option('reverb-port');

        $this->info('🚀 Starting LavaChat Development Environment');
        $this->newLine();
        
        $this->info("📡 Reverb WebSocket Server: http://localhost:{$reverbPort}");
        $this->info("🌐 Laravel Development Server: http://{$host}:{$port}");
        $this->newLine();

        $this->comment('To start both servers manually, run:');
        $this->line("  • php artisan reverb:start --port={$reverbPort}");
        $this->line("  • php artisan serve --host={$host} --port={$port}");
        $this->newLine();

        $this->comment('Or use the batch file: start-dev.bat');
        $this->comment('Or use npm scripts: npm run start');
        
        return 0;
    }
}
