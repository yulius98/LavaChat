<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeWithReverb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:reverb {--host=127.0.0.1} {--port=8000} {--reverb-port=8081}';

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
        $reverbPort = $this->option('reverb-port');

        $this->info("Starting Laravel development server on http://{$host}:{$port}");
        $this->info("Starting Reverb WebSocket server on port {$reverbPort}");
        $this->newLine();

        // Start Reverb server in background
        $reverbProcess = new Process([
            'php', 
            'artisan', 
            'reverb:start', 
            '--port=' . $reverbPort
        ]);
        $reverbProcess->setTimeout(null);
        $reverbProcess->start();

        $this->info("✓ Reverb WebSocket server started on port {$reverbPort}");

        // Start Laravel development server
        $serveProcess = new Process([
            'php', 
            'artisan', 
            'serve', 
            '--host=' . $host, 
            '--port=' . $port
        ]);
        $serveProcess->setTimeout(null);

        $this->info("✓ Laravel development server starting on http://{$host}:{$port}");
        $this->newLine();
        $this->comment('Press Ctrl+C to stop both servers');
        $this->newLine();

        // Handle graceful shutdown (simplified for Windows compatibility)
        register_shutdown_function(function () use ($reverbProcess) {
            if ($reverbProcess->isRunning()) {
                $reverbProcess->stop();
            }
        });

        // Run the serve command and wait for it to finish
        $serveProcess->run(function ($type, $buffer) {
            echo $buffer;
        });

        // Stop Reverb when serve stops
        if ($reverbProcess->isRunning()) {
            $reverbProcess->stop();
        }
    }
}
