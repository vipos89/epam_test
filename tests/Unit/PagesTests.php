<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesTests extends TestCase
{
    use WithFaker;

    public function testPagesAvailable(): void
    {
        $url = $this->faker->url;
        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSeeText($url);
    }

    public function testErrorPage(): void
    {
        $url = '';
        for ($i = 0; $i < 5; $i++) {
            $url .= $this->faker->url;
        }
        $response = $this->get($url);
        $response->assertStatus(404);
        $response->assertSeeText(404);
    }
}
