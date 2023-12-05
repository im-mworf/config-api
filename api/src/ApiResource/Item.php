<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\State\ItemStateProcessor;
use App\State\ItemStateProvider;

#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    provider: ItemStateProvider::class,
    processor: ItemStateProcessor::class
)]
class Item implements ResourceInterface
{
    #[ApiProperty(readable: true, identifier: true)]
    public string $key;

    #[ApiProperty(readable: true)]
    public string $name;

    #[ApiProperty(readable: true)]
    public ?string $value;
}
