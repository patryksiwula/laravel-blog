<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testHomepageRedirectsToPostList(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/posts');
    }
}
