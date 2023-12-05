<?php

namespace App\Mapper;

use App\ApiResource\ResourceInterface;
use App\Entity\EntityInterface;
use ReflectionClass;

class EntityMapper implements EntityMapperInterface
{
    /**
     * @throws \ReflectionException
     */
    // TODO: make recursive for deep objects
    public function map(
        EntityInterface $entity,
        ResourceInterface $resource
    ): EntityInterface {
        $resourceReflection = new ReflectionClass(get_class($resource));
        $entityReflection = new ReflectionClass(get_class($entity));

        // map via entity set{$property}() method if it exists
        foreach ($resourceReflection->getProperties() as $property) {
            $methodName = 'set' . ucfirst($property->getName());
            if ($entityReflection->hasMethod($methodName)) {
                $method = $entityReflection->getMethod($methodName);
                $method->invoke($entity, $property->getValue($resource));
            }
        }

        return $entity;
    }
}
