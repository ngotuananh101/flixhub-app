<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function show(string $setting)
    {
        $data = [
            'setting' => $setting,
        ];
        $page = null;
        switch ($setting) {
            case 'general':
                $page = view('pages.admin.settings.general', $data);
                break;
            case 'mail':
                $page = view('pages.admin.settings.mail', $data);
                break;
            case 'logging':
                $data['logChannels'] = [
                    'single' => 'Single',
                    'daily' => 'Daily',
                    'slack' => 'Slack',
                    'syslog' => 'Syslog',
                    'errorlog' => 'Errorlog',
                    'monolog' => 'Monolog',
                    'custom' => 'Custom',
                    'stack' => 'Stack',
                    'null' => 'Null',
                ];
                $data['logLevels'] = [
                    'debug' => 'Debug',
                    'info' => 'Info',
                    'notice' => 'Notice',
                    'warning' => 'Warning',
                    'error' => 'Error',
                    'critical' => 'Critical',
                    'alert' => 'Alert',
                    'emergency' => 'Emergency',
                ];
                $page = view('pages.admin.settings.logging', $data);
                break;
            case 'cache':
                $data['cacheProviders'] = [
                    'apc' => 'APC',
                    'array' => 'Array',
                    'database' => 'Database',
                    'file' => 'File',
                    'memcached' => 'Memcached',
                    'redis' => 'Redis',
                    'dynamodb' => 'DynamoDB',
                    'octane' => 'Octane',
                    'null' => 'Null',
                ];
                $page = view('pages.admin.settings.cache', $data);
                break;
            default:
                abort(404);
        }
        return $page;
    }

    /**
     * Update system settings
     *
     * @param Request $request
     * @param string $section
     * @return RedirectResponse
     */
    public function update(Request $request, string $section = 'general')
    {
        $response = null;
        switch ($section) {
            case 'general':
                $response = $this->updateGeneral($request);
                break;
            case 'cache':
                $response = $this->updateCache($request);
                break;
            case 'mail':
                $response = $this->updateEmail($request);
                break;
            case 'logging':
                $response = $this->updateLogging($request);
                break;
            case 'clearCache':
                $response = $this->clearCache();
                break;
            default:
                abort(404);
        }
        return $response;
    }

    /**
     * Update application general settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'required|string|max:255',
            'app_url' => 'required|url',
            'app_timezone' => 'required|string',
            'app_locale' => 'required|string',
            'app_theme' => 'required|string|in:light,dark',
            'app_favicon' => 'nullable|image|mimes:png',
            'app_logo_small' => 'nullable|image|mimes:png',
            'app_logo' => 'nullable|image|mimes:png',
            'app_logo_dark' => 'nullable|image|mimes:png',
        ]);
        try {
            $settings = $request->only([
                'app_name',
                'app_description',
                'app_url',
                'app_timezone',
                'app_locale',
                'app_theme',
            ]);

            if ($request->hasFile('app_favicon')) {
                $file = $request->file('app_favicon');
                $file->move(public_path('assets/media/favicons'), 'favicon.png');
                $settings['app_favicon'] = 'assets/media/favicons/favicon.png';
            }

            if ($request->hasFile('app_logo_small')) {
                $file = $request->file('app_logo_small');
                $file->move(public_path('assets/media/logos'), 'logo-small.png');
                $settings['app_logo_small'] = 'assets/media/logos/logo-small.png';
            }

            if ($request->hasFile('app_logo')) {
                $file = $request->file('app_logo');
                $file->move(public_path('assets/media/logos'), 'logo.png');
                $settings['app_logo'] = 'assets/media/logos/logo.png';
            }

            if ($request->hasFile('app_logo_dark')) {
                $file = $request->file('app_logo_dark');
                $file->move(public_path('assets/media/logos'), 'logo-dark.png');
                $settings['app_logo_dark'] = 'assets/media/logos/logo-dark.png';
            }

            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
                $this->updateEnv($key, $value);
            }
            if (cache()->has('settings')) {
                cache()->forget('settings');
            }
            return redirect()->back()->with('success', 'General settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update application cache settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCache(Request $request)
    {
        $request->validate([
            'cache_store' => 'required|string|in:apc,array,database,file,memcached,redis,dynamodb,octane,null',
        ]);
        try {
            $old = Setting::where('key', 'cache_store')->first();
            if (cache()->has('settings')) {
                cache()->forget('settings');
            }
            $this->updateEnv('cache_store', $request->cache_store);
            try {
                Cache::driver($request->cache_store)->put('test', 'test', 60);
            } catch (\Exception $e) {
                $this->updateEnv('cache_store', $old->value);
                return redirect()->back()->withErrors(['cache_store' => $e->getMessage()]);
            } catch (\Error $e) {
                $this->updateEnv('cache_store', $old->value);
                return redirect()->back()->withErrors(['cache_store' => $e->getMessage()]);
            }
            Setting::updateOrCreate(['key' => 'cache_store'], ['value' => $request->cache_store]);
            return redirect()->back()->with('success', 'Cache settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update application email settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_host' => 'required|string',
            'mail_port' => 'required|string',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string|in:tls,ssl,null',
            'mail_from_address' => 'required|string|email',
            'mail_from_name' => 'required|string',
        ]);
        try {
            $settings = $request->only([
                'mail_mailer',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
            ]);
            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
                $this->updateEnv($key, $value);
            }
            if (cache()->has('settings')) {
                cache()->forget('settings');
            }
            return redirect()->back()->with('success', 'Email settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update application logging settings
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateLogging(Request $request)
    {
        $request->validate([
            'sentry_laravel_dsn' => 'nullable|string',
            'sentry_client_key' => 'nullable|string',
            'sentry_traces_sample_rate' => 'required_if:sentry_laravel_dsn,!=,null|numeric|min:0|max:1',
            'log_channel' => 'required|string|in:single,daily,slack,syslog,errorlog,monolog,custom,stack,null',
            'log_level' => 'required|string|in:debug,info,notice,warning,error,critical,alert,emergency',
        ]);
        try {
            $settings = $request->only([
                'sentry_laravel_dsn',
                'sentry_client_key',
                'sentry_traces_sample_rate',
                'log_channel',
                'log_level',
            ]);
            if ($request->has('sentry_traces_sample_rate')) {
                // Convert to float with 1 decimal point
                $settings['sentry_traces_sample_rate'] = number_format($settings['sentry_traces_sample_rate'], 1);
            }
            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
                $this->updateEnv($key, $value);
            }
            if (cache()->has('settings')) {
                cache()->forget('settings');
            }
            return redirect()->back()->with('success', 'Logging settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function clearCache()
    {
        Cache::flush();
        return redirect()->back()->with('success', 'Cache cleared successfully');
    }

    protected function updateEnv($key, $value)
    {
        $key = strtoupper($key);
        $envFile = app()->environmentFilePath();
        $contents = file_get_contents($envFile);
        foreach (explode("\n", $contents) as $line) {
            if (str_contains($line, $key)) {
                $contents = str_replace($line, $key . '="' . $value . '"', $contents);
                file_put_contents($envFile, $contents);
                break;
            }
        }
    }
}
