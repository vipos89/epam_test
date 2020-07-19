<?php


namespace App\Services\LogAnalyzers\WebServerLogs;


use App\Services\FileReader;
use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use Kassner\LogParser\LogParser;

abstract class BaseServerLog
{
    const LINES_COUNT = 10;

    protected $filename;
    /**
     * @var LogParser
     */
    protected $parser;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $data;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $parsedData;

    public function __construct()
    {
        $this->data = $this->parsedData =  collect([]);
        $this->parser = new LogParser();
    }


    public function readData($linesCount = 50)
    {
        $totalLines = intval(exec("wc -l '{$this->filename}'"));
        $reader = new FileReader($this->filename);
        $iterationCounts = ceil($totalLines / $linesCount);
        $reader->setOffset(0);
        for ($i = 0; $i < $iterationCounts; $i++) {
            $this->data = $this->data->merge(collect($reader->read($linesCount)));
        }
    }

    public function setParserFormat($format)
    {
        $this->parser->setFormat($format);
    }

    public function parseData()
    {
        foreach ($this->data as $item) {
            $this->parsedData->add([$this->parser->parse($item)]);
        }
    }

    abstract public function getAnalytics($fullMode = false);


}
