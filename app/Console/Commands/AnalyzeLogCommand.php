<?php

namespace App\Console\Commands;

use App\Services\LogAnalyzers\TextLog;
use Exception;
use Illuminate\Console\Command;


class AnalyzeLogCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyze:log {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        try {
            $analyzer = new TextLog();
            $analyzer->setFile($this->argument('file'));
            $analyzer->readData();
            $analyzer->parseData();
            $res = $analyzer->getAnalytics(true);
            foreach (array_keys($res) as $key)
            {
                $this->info($key);
                $data = $res[$key];
                $headers = array_keys($data->first());
                $this->table($headers, $data);
            }
        }catch (Exception $exception){
            $this->error($exception->getMessage());
            return 1;
        }

        return 0;
    }

}
