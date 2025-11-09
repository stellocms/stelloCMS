<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PluginManager;

class InstallContohPlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:install-contoh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install ContohPlugin';

    /**
     * Execute the console command.
     */
    public function handle(PluginManager $pluginManager)
    {
        $this->info('Installing ContohPlugin...');
        
        $result = $pluginManager->installPlugin('ContohPlugin');
        
        if ($result) {
            $this->info('ContohPlugin installed successfully!');
        } else {
            $this->error('Failed to install ContohPlugin. Make sure the plugin exists in app/Plugins/ContohPlugin directory.');
        }
    }
}