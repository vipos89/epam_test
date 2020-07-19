<?php


namespace App\Services\LogAnalyzers\Interfaces;


interface LogAnalyzerInterface
{
    public function setFile($filename);

    public function readData();

    public function parseData();

    public function getAnalytics($fullMode = false);
}
