<?php


namespace App\Services\LogAnalyzers;


use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use App\Services\LogAnalyzers\WebServerLogs\BaseServerLog;

class ApacheLog extends BaseServerLog implements LogAnalyzerInterface
{
    protected $filename;

    private $format =  "%h %l %u %t \"%r\" %>s %b";

    public function __construct()
    {
        parent::__construct();
        $this->parser->setFormat($this->format);
    }

    public function setFile($filename)
    {
        $this->filename = $filename;
    }

    public function parseData()
    {
        // TODO: Implement parseData() method.
    }

    public function getAnalytics($fullMode = false)
    {
        // TODO: Implement getAnalytics() method.
    }

}
