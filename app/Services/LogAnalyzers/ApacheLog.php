<?php


namespace App\Services\LogAnalyzers;


use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use App\Services\LogAnalyzers\WebServerLogs\BaseServerLog;

class ApacheLog extends BaseServerLog implements LogAnalyzerInterface
{

    public function __construct()
    {
        parent::__construct();
        $format = $format = env('APACHE_LOG_FORMAT', "%h %l %u %t \"%r\" %>s %b");
        $this->parser->setFormat($format);
    }

    public function getAnalytics($fullMode = false)
    {
        // TODO: Implement getAnalytics() method.
    }

}
