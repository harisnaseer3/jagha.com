<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class DBBackupController extends Controller
{
    public function index()
    {
        // Get backup files
        $backupFiles = collect(Storage::files('backups'))
            ->map(function ($file) {
                return [
                    'date' => Carbon::createFromTimestamp(Storage::lastModified($file))->format('Y-m-d H:i:s'),
                    'filename' => basename($file),
                    'filesize' => round(Storage::size($file) / 1024 / 1024, 2) . ' MB',
                ];
            });

        return view('backup.index', compact('backupFiles'));
    }

    public function create()
    {
        Artisan::call('database:backup');
        return back()->with('success', 'Backup created successfully!');
    }

    public function delete($filename)
    {
        Storage::delete('backups/' . $filename);
        return back()->with('success', 'Backup deleted successfully!');
    }

    public function restore($filename)
    {
        $db_host = env('DB_HOST');
        $db_name = env('DB_DATABASE');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');

        $backup_file = base_path("property_media/public/backups/{$filename}");

        if (!file_exists($backup_file)) {
            return back()->with('error', 'Backup file not found.');
        }

        $command = "gunzip < {$backup_file} | mysql -h {$db_host} -u {$db_user} -p'{$db_pass}' {$db_name}";
        system($command);

        return back()->with('success', 'Database restored successfully!');
    }

    public function download($filename)
    {
        $filePath = base_path('property_media/public/backups/' . $filename);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download($filePath);
    }
}

