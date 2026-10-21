<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Smoke test: every STOMAN page renders in its empty state (PRD section 12).
 */
class PagesRenderTest extends TestCase
{
    public static function pageRoutes(): array
    {
        return [
            'home' => ['/', 200],
            'login' => ['/login', 200],
            'register' => ['/register', 200],
            'storage' => ['/storage', 200],
            'storage folder' => ['/storage/documents', 200],
            'shared' => ['/shared', 200],
            'recent' => ['/recent', 200],
            'starred' => ['/starred', 200],
            'archive' => ['/archive', 200],
            'trash' => ['/trash', 200],
            'settings' => ['/settings', 200],
            'error 403' => ['/errors/403', 403],
            'error 404' => ['/errors/404', 404],
            'error 500' => ['/errors/500', 500],
            'missing page' => ['/definitely-missing', 404],
        ];
    }

    #[DataProvider('pageRoutes')]
    public function test_pages_render(string $uri, int $status): void
    {
        $response = $this->get($uri);

        $response->assertStatus($status);
        $response->assertSee('STOMAN');
    }

    public function test_pages_contain_no_raw_hex_colors(): void
    {
        foreach (self::pageRoutes() as [$uri, $status]) {
            $body = $this->get($uri)->getContent();

            // PRD 11: no raw hex values reach the markup.
            $this->assertDoesNotMatchRegularExpression(
                '/(?:style|class)="[^"]*#[0-9a-fA-F]{3,8}/',
                $body,
                "Raw hex color found in rendered markup of {$uri}",
            );
        }
    }
}
