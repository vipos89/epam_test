<?php


namespace App\Services\LogAnalyzers;


use App\Services\FileReader;
use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Self_;

class TextLog implements LogAnalyzerInterface
{
    public const LINES_COUNT = 50;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $data;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $parsedData;
    private $filename;

    private const SLICE_SIZE_FOR_SHOT_REPO = 10;

    public function __construct()
    {
        $this->data = $this->parsedData = collect([]);
    }


    public function readData()
    {
        if (!Storage::exists($this->filename)) {
            throw new \Exception('file not found');
        }
        $filePath = Storage::path($this->filename);
        $file = new \SplFileObject($filePath, 'r');
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key() + 1;
        if ($totalLines) {
            $iterationCounts = ceil($totalLines / (self::LINES_COUNT));
            $reader = new FileReader($filePath);
            $reader->setOffset(0);
            for ($i = 0; $i < $iterationCounts; $i++) {
                $this->data = $this->data->merge(collect($reader->read(self::LINES_COUNT)));
            }
        }
    }

    public function parseData()
    {
        foreach ($this->data as $line) {
            [$page, $userIp] = explode(' ', $line);
            $this->parsedData->add(compact('page', 'userIp'));
        }


    }

    public function setFile($filename)
    {
        $this->filename = $filename;
    }

    public function getAnalytics($fullMode = false)
    {
        $pagesStatistic = $this->getGroupedStatistic('page', $fullMode);
        $ipsStatistic = $this->getGroupedStatistic('userIp', $fullMode);
        return compact('pagesStatistic', 'ipsStatistic');
    }

    private function getGroupedStatistic($groupBy, $fullMode = false)
    {
        $groupedData = $this->parsedData->groupBy($groupBy);
        $keys = $groupedData->keys();
        $statistic = collect([]);
        foreach ($keys as $key) {
            $statistic->add(['key' => $key, 'value' => $groupedData->get($key)->count()]);
        }
        $statistic = $statistic->sortByDesc('value');
        return $fullMode? $statistic:$statistic->slice(0, self::SLICE_SIZE_FOR_SHOT_REPO);
    }
}
