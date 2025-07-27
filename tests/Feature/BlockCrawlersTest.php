<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlockCrawlersTest extends TestCase
{
    /** @test */
    public function it_blocks_known_crawlers()
    {
        $response = $this->get('/post/accepting-multiple-parameters-for-commands-in-laravel', [
            'User-Agent' => 'Googlebot/2.1 (+http://www.google.com/bot.html)'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function it_allows_normal_user_requests()
    {
        $response = $this->get('/post/accepting-multiple-parameters-for-commands-in-laravel', [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
        ]);

        $response->assertStatus(200); // or 404 if route doesn't exist
    }
}
