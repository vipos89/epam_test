<?php


namespace App\Services\LogAnalyzers;


use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use App\Services\LogAnalyzers\WebServerLogs\BaseServerLog;


class NginxLog extends BaseServerLog implements LogAnalyzerInterface
{

    protected $filename;


    public function __construct()
    {
        parent::__construct();
        $format = $format = env('NGINX_LOG_FORMAT', '%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
        $this->parser->setFormat($format);
    }

    public function getAnalytics($fullMode = false)
    {
        // TODO: Implement getAnalytics() method.
    }

}
