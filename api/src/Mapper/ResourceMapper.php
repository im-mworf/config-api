<?php

declare(strict_types=1);

namespace App\Mapper;

use App\ApiResource\ResourceInterface;
use App\Entity\EntityInterface;
use ReflectionClass;

class ResourceMapper implements ResourceMapperInterface
{
    /**
     * @throws \ReflectionException
     */
    // TODO: make recursive for deep objects
    public function map(
        ResourceInterface $resource,
        EntityInterface $entity
    ): ResourceInterface {
        $resourceReflection = new ReflectionClass(get_class($resource));
        $entityReflection = new ReflectionClass(get_class($entity));

        // map via entity get{$property}() method if it exists
        foreach ($resourceReflection->getProperties() as $property) {
            $methodName = 'get' . ucfirst($property->getName());
            if ($entityReflection->hasMethod($methodName)) {
                $method = $entityReflection->getMethod($methodName);
                $resource->{$property->getName()} = $method->invoke($entity);
            }
        }

        return $resource;
    }
}
