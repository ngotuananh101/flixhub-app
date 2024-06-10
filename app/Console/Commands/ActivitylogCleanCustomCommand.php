<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\ActivitylogServiceProvider;


class ActivitylogCleanCustomCommand extends Command
{
    protected $signature = 'activitylog:clean-custom';

    protected $description = 'Custom command to clean activity log';

    public function handle(): void
    {
        $maxAgeInDays = config('activitylog.delete_records_older_than_days');
        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');
        $backupDirectory = config('activitylog.backup_log_dictionary');
        if (!is_dir($backupDirectory)) {
            mkdir($backupDirectory, 0777, true);
        }

        // Backup to sql file before deleting
        $activity = ActivitylogServiceProvider::getActivityModelInstance();
        $data = $activity::query()->where('created_at', '<', $cutOffDate)->get();
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.json';
        $filename = $backupDirectory . $filename;
        file_put_contents($filename, $jsonData);
        // Delete from database
        $activity::query()->where('created_at', '<', $cutOffDate)->delete();
        Log::info('Activity log cleaned successfully.');
    }
}
