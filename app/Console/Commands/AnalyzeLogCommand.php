<?php

namespace App\Console\Commands;

use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use App\Services\LogAnalyzers\TextLog;
use Illuminate\Console\Command;


class AnalyzeLogCommand extends Command
{
    protected static $types =[
        'text'=> TextLog::class,
    ];

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $logType = $this->option('type');
        $analyzer = $this->getLogAnalyzer($logType);
        $analyzer->setFile($this->argument('file'));
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
        return 0;
    }

    /**
     * @param $logType
     * @return LogAnalyzerInterface
     * @throws \Exception
     */
    private function getLogAnalyzer(string $logType)
    {
        $analyzerTypes = array_keys(self::$types);
        if(in_array($logType, $analyzerTypes)){
            return new self::$types[$logType];
        }
        throw  new \Exception('Incorrect log type');
    }

}
