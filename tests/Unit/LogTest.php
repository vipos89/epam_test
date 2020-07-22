<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LogTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testLogIsset()
    {
        Storage::fake('local');
        $this->get('/');
        Storage::disk('local')->assertExists('web.log');
    }
}
