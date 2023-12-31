<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ItemTest extends ApiTestCase
{
    public function testCreateItem(): void
    {
        static::createClient()->request('POST', '/items', [
            'json' => [
                'slug' => 'TEST-KEY-BASE-URL',
                'name' => 'base-url',
                'value' => 'http://localhost/',
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Item',
            '@type' => 'Item',
            'slug' => 'TEST-KEY-BASE-URL',
            'name' => 'base-url',
            'value' => 'http://localhost/',
        ]);
    }
}
