<?php


namespace App\Services\LogAnalyzers;


use App\Services\FileReader;
use App\Services\LogAnalyzers\Interfaces\LogAnalyzerInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Class TextLog
 *
 * @category Service
 * @quthor   vipos89
 * @package  App\Services\LogAnalyzers
 */
class TextLog implements LogAnalyzerInterface
{
    /**
     *
     */
    public const LINES_COUNT = 50;
    /**
     * @var Collection
     */
    private $data;
    /**
     * @var Collection
     */
    private $parsedData;
    /**
     * @var
     */
    private $filename;

    /**
     *
     */
    private const SLICE_SIZE_FOR_SHOT_REPO = 10;

    /**
     * TextLog constructor.
     */
    public function __construct()
    {
        $this->data = $this->parsedData = collect([]);
    }


    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function readData()
    {
        if (!File::exists($this->filename)) {
            throw new \Exception('file not found');
        }

        $totalLines = $this->getFileLinesCount();
        if ($totalLines) {
            $iterationCounts = ceil($totalLines / (self::LINES_COUNT));
            try {
                $reader = new FileReader($this->filename);
                $reader->setOffset(0);
                for ($i = 0; $i < $iterationCounts; $i++) {
                    $this->data = $this->data->merge(collect($reader->read(self::LINES_COUNT)));
                }
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }

        }
    }

    /**
     * @return mixed|void
     */
    public function parseData()
    {
        foreach ($this->data as $line) {
            // skip empty lines
            if ($line) {
                [$page, $userIp] = explode(' ', $line);
                $this->parsedData->add(compact('page', 'userIp'));
            }
        }
    }

    /**
     * @param  $filename
     * @return mixed|void
     */
    public function setFile($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param  bool $fullMode
     * @return array|mixed
     */
    public function getAnalytics($fullMode = false)
    {
        $pagesStatistic = $this->getGroupedStatistic('page', $fullMode);
        $ipsStatistic = $this->getGroupedStatistic('userIp', $fullMode);
        return compact('pagesStatistic', 'ipsStatistic');
    }

    /**
     * @param  $groupBy
     * @param  bool $fullMode
     * @return Collection
     */
    private function getGroupedStatistic($groupBy, $fullMode = false)
    {
        $groupedData = $this->parsedData->groupBy($groupBy);
        $keys = $groupedData->keys();
        $statistic = collect([]);
        foreach ($keys as $key) {
            $statistic->add(['key' => $key, 'value' => $groupedData->get($key)->count()]);
        }
        $statistic = $statistic->sortByDesc('value');
        return $fullMode ? $statistic : $statistic->slice(0, self::SLICE_SIZE_FOR_SHOT_REPO);
    }

    /**
     * @return int
     */
    private function getFileLinesCount()
    {
        $file = new \SplFileObject($this->filename, 'r');
        $file->seek(PHP_INT_MAX);
        return $file->key() ? +1 : 0;
    }


    /**
     * @return Collection
     */
    public function getParsedData()
    {
        return $this->parsedData;
    }
}
