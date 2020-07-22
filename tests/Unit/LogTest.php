<?php

namespace Tests\Unit;

use App\Services\LogAnalyzers\TextLog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LogTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testLogIsset(): void
    {
        $this->get($this->faker->url);
        $this->assertTrue(File::exists(config('statistic.log_path')));
    }

    public function testLogAdded(): void
    {
        $url = $this->faker->url;
        $this->get($url);
        $analyzer = new TextLog();
        $analyzer->setFile(config('statistic.log_path'));
        $analyzer->readData();
        $analyzer->parseData();
        $this->assertContains($url, $analyzer->getParsedData()->keys()->toArray());
    }

    public function testFileNotAdded(): void
    {
        $this->artisan('analyze:log')
            ->assertExitCode(0);

    }

    public function testFileNotExists(): void
    {
        $filename =$this->faker->title.'.'.$this->faker->fileExtension;
        $this->artisan('analyze:log '.$filename)
            ->assertExitCode(1);

    }

}
