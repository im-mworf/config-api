<?php

declare(strict_types=1);

namespace App\Mapper;

use App\ApiResource\ResourceInterface;
use App\Entity\EntityInterface;

interface ResourceMapperInterface
{
    public function map(ResourceInterface $resource, EntityInterface $entity): ResourceInterface;
}
