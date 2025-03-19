<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'database:backup';
    protected $description = 'Backup MySQL database and compress it';

    public function handle()
    {
        $db_host = env('DB_HOST');
        $db_name = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');

        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupDir = base_path("property_media/public/backups/");
        $backupFile = "{$backupDir}db_backup_{$timestamp}.sql.gz";

        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $command = "mysqldump -h {$db_host} -u {$db_user} --password={$db_pass} {$db_name} 2> {$backupDir}error.log | gzip > {$backupFile}";

        system($command, $output);

        if (filesize($backupFile) > 0) {
            $this->info("Database backup created: {$backupFile}");
        } else {
            $this->error("Database backup failed. Check error.log for details.");
        }
    }
}
