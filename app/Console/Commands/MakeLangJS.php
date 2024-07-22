<?php

namespace App\Console\Commands;

use App\Models\Setting;
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
            // Get all the languages
            $locales = Setting::where('key', 'locales')->pluck('value');
            $locales = json_decode($locales[0]);
            $transFunction = 'const t = (source, key, attribute) => { let string = translation[source][key]; if (string && attribute !== undefined) { string  = string.split(" "); for (let i = 0; i < string.length; i++) { if (string[i].startsWith(":")) { string[i] = attribute[string[i].replace(":", "")]; } } string = string.join(" "); } return string; };';

            foreach ($locales as $locale) {
                app()->setLocale($locale);

                // Get validation messages and convert them
                $validationMessages = __('validation');
                $validation = $this->flattenArray($validationMessages);
                // Get auth and admin translations
                $authMessages = __('auth');
                $auth = $this->flattenArray($authMessages);
                // Get admin translations
                $adminMessages = __('admin');
                $admin = $this->flattenArray($adminMessages);

                // Prepare JSON
                $json = json_encode([
                    'validation' => $validation,
                    'auth' => $auth,
                    'admin' => $admin,
                ]);

                // Prepare JS content
                $js = 'var translation = ' . $json . ';';
                $js = $transFunction . ' ' . $js;

                // Write to file
                $file = public_path('assets/lang/translation.' . app()->getLocale() . '.js');
                file_put_contents($file, $js);
            }

            $this->info('Translation files have been created successfully.');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    public function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            }
            else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
}
