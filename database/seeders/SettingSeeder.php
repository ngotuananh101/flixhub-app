<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $env = file_get_contents(base_path('.env'));
        $env = explode("\n", $env);
        $settings = [];
        foreach ($env as $line) {
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }
            $line = explode('=', $line);
            // remove quotes
            $line[1] = str_replace('"', '', $line[1]);
            $settings[$line[0]] = $line[1];
        }
        $settings['locales'] = json_encode(['en']);
        $settings['app_favicon'] = 'assets/media/favicons/favicon.png';
        $settings['app_logo_small'] = 'assets/media/logos/logo-small.png';
        $settings['app_logo'] = 'assets/media/logos/logo.png';
        $settings['app_logo_dark'] = 'assets/media/logos/logo-dark.png';

        foreach ($settings as $key => $value) {
            $key = strtolower($key);
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
