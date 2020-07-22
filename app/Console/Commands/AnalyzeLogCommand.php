<?php

namespace App\Console\Commands;

use App\Services\LogAnalyzers\TextLog;
use Illuminate\Console\Command;


class AnalyzeLogCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyze:log {file} {--type=text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $analyzer = new TextLog();

            $analyzer->setFile();
            $analyzer->readData();
            $analyzer->parseData();
            $res = $analyzer->getAnalytics(true);
            $keys = array_keys($res);
            foreach ($keys as $key)
            {
                $this->info($key);
                $data = $res[$key];
                $headers = array_keys($data->first());
                $this->table($headers, $data);
            }
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
        }

        return 0;
    }

}
