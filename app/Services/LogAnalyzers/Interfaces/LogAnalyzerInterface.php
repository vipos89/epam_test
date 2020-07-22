<?php


namespace App\Services\LogAnalyzers\Interfaces;


/**
 * Interface LogAnalyzerInterface
 *
 * @package App\Services\LogAnalyzers\Interfaces
 */
interface LogAnalyzerInterface
{
    /**
     * set filename for analyze
     *
     * @param  $filename
     * @return mixed
     */
    public function setFile($filename);

    /**
     * Read data from file
     *
     * @return mixed
     */
    public function readData();

    /**
     * Parse data
     *
     * @return mixed
     */
    public function parseData();

    /**
     * @param  bool $fullMode
     * @return mixed
     */
    public function getAnalytics($fullMode = false);
}
