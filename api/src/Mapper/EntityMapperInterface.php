<?php

namespace App\Mapper;

use App\ApiResource\ResourceInterface;
use App\Entity\EntityInterface;

Interface EntityMapperInterface
{
    public function map(EntityInterface $entity, ResourceInterface $resource): EntityInterface;
}
