<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ZipTest extends TestCase
{
    use WithFaker;
    /**
     *
     * @return void
     */
    public function testDefaultArtisanZip(): void
    {
        Storage::fake('local');
        $filename ='log.test';
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filePath = $storagePath.$filename;
        Storage::put($filename, ''); //Empty file
        $zipPath = $storagePath;
        $this->artisan('zip:logs --file='.$filePath.'--zip_path='.$zipPath)
            ->assertExitCode(0);
        $this->assertTrue(File::exists($zipPath));
    }

}
