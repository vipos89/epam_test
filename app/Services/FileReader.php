<?php


namespace App\Services;


use Exception;

class FileReader
{
    protected $fileHandler;
    protected $fileBuffer = [];

    public function __construct($filename)
    {
        if (!$this->fileHandler = fopen($filename, 'rb')) {
            throw new Exception('Cannot open file');
        }
    }


    public function read($lines = 50): array
    {
        if (!$this->fileHandler) {
            throw new Exception('Incorrect handler');
        }
        $this->fileBuffer = [];
        while (!feof($this->fileHandler)) {
            $this->fileBuffer[] =  trim(str_replace(["\r", "\n", "\t"],"", fgets($this->fileHandler)));
            $lines--;
            if (!$lines) {
                break;
            }
        }
        return $this->fileBuffer;
    }

    public function setOffset($line = 0)
    {
        if (!$this->fileHandler)
            throw new Exception("Invalid file pointer");

        while (!feof($this->fileHandler) && $line--) {
            fgets($this->fileHandler);
        }
    }


}
