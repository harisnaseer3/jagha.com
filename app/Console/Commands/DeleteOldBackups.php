<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DeleteOldBackups extends Command
{
    protected $signature = 'database:cleanup';
    protected $description = 'Delete database backups older than 10 days';

    public function handle()
    {
        $files = Storage::files('backups');
        $cutoff = Carbon::now()->subDays(10);

        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp(Storage::lastModified($file));

            if ($lastModified->lessThan($cutoff)) {
                Storage::delete($file);
                $this->info("Deleted old backup: {$file}");
            }
        }
    }
}
