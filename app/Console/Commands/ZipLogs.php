<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\File;
use ZipArchive;

class ZipLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:logs {--file=} {--zip_path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive log';


    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        $logFile = $this->option('file') ?? config('statistic.log_path');
        $date = Carbon::yesterday()->toDateString();
        $zipName = $this->option('zip_path') ?? config('statistic.zip_dir') . $date . '.zip';

        if ($logFile && File::exists($logFile)) {
            $zip = new ZipArchive();
            if ($zip->open($zipName, ZipArchive::CREATE) === true) {
                $zip->addFile($logFile, basename($logFile));
                $zip->close();
                File::delete($logFile);
            }

        } else {
            $this->info('File not exists');
            return 1;
        }
        return 0;
    }
}
