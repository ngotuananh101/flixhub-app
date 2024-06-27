<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeLangJS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:lang-js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $script = __('admin');
            $json = json_encode($script);
            $js = 'var translation = ' . $json . ';';
            $file = public_path('assets/lang/translation.js');
            file_put_contents($file, $js);
            $this->info('Admin translation file has been created successfully.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

        try {
            $script = __('auth');
            $json = json_encode($script);
            $js = 'var translation = ' . $json . ';';
            $file = public_path('assets/lang/auth.js');
            file_put_contents($file, $js);
            $this->info('Auth translation file has been created successfully.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
