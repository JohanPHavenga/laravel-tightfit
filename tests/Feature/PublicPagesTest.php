<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_auth_routes_are_gone(): void
    {
        $this->get('/login')->assertNotFound();
        $this->get('/register')->assertNotFound();
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/about', '/contact', '/gallery', '/gallery/garagedoors'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_the_menu_no_longer_links_to_manuals(): void
    {
        $this->get('/')->assertDontSee('/manuals');
    }
}
