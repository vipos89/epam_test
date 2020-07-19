<?php


namespace App\Services\LogAnalyzers;


use App\Services\FileReader;
use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use App\Services\LogAnalyzers\Traits\ParserTrait;
use App\Services\LogAnalyzers\WebServerLogs\BaseServerLog;
use Kassner\LogParser\LogParser;

class NginxLog extends BaseServerLog implements LogAnalyzerInterface
{

    protected $filename;

    private $format = "%h %l %u %t \"%r\" %>s %b";

    public function __construct()
    {
        parent::__construct();
        $this->parser->setFormat($this->format);
    }

    public function setFile($filename)
    {
        $this->filename = $filename;
    }

    public function getAnalytics($fullMode = false)
    {
        // TODO: Implement getAnalytics() method.
    }

}
