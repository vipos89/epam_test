<?php


namespace App\Services\LogAnalyzers;


use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;

 class BaseLogAnalyzer implements LogAnalyzerInterface
{

     public function setFile($filename)
     {
         // TODO: Implement setFile() method.
     }

     public function readData()
     {
         // TODO: Implement readData() method.
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
