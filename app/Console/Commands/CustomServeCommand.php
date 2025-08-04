<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CustomServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:with-reverb {--host=127.0.0.1} {--port=8000} {--no-reverb : Skip starting Reverb server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Laravel development server with Reverb WebSocket server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $skipReverb = $this->option('no-reverb');

        if (!$skipReverb) {
            $this->info('🚀 Starting LavaChat Development Environment');
            $this->newLine();
            
            // Check if Reverb is already running
            $reverbRunning = $this->isPortInUse(8081);
            
            if (!$reverbRunning) {
                $this->info('📡 Starting Reverb WebSocket Server on port 8081...');
                
                // Start Reverb in background (Windows compatible)
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $reverbCommand = "start \"Reverb Server\" cmd /c \"php artisan reverb:start --port=8081\"";
                    shell_exec($reverbCommand);
                } else {
                    // For Unix-like systems
                    shell_exec('php artisan reverb:start --port=8081 > /dev/null 2>&1 &');
                }
                
                sleep(2); // Wait for Reverb to start
                $this->info('✅ Reverb WebSocket Server started');
            } else {
                $this->comment('📡 Reverb WebSocket Server already running on port 8081');
            }
        }

        $this->info("🌐 Starting Laravel Development Server on http://{$host}:{$port}");
        $this->newLine();
        
        if (!$skipReverb) {
            $this->comment('💡 Both servers are now running:');
            $this->line("   • Laravel: http://{$host}:{$port}");
            $this->line("   • Reverb WebSocket: ws://localhost:8081");
            $this->newLine();
        }

        // Start Laravel development server
        $serveCommand = "php artisan serve --host={$host} --port={$port}";
        passthru($serveCommand);
    }

    /**
     * Check if a port is already in use
     */
    private function isPortInUse($port)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = shell_exec("netstat -ano | findstr :{$port}");
            return !empty(trim($output));
        } else {
            $output = shell_exec("lsof -i :{$port}");
            return !empty(trim($output));
        }
    }
}
