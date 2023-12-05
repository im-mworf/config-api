<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Item as ItemResource;
use App\Mapper\ResourceMapper;
use App\Repository\ItemRepository;

readonly class ItemStateProvider implements ProviderInterface
{
    public function __construct(
        private ItemRepository $itemRepository,
        private ResourceMapper $resourceMapper
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {
        // fetch the entity using the repository
        $item = $this->itemRepository->findOneBy($uriVariables);

        // return if entity is null/not found
        if ($item === null) {
            return null;
        }

        // map the entity to the api resource - lots of opportunity
        // here we use a resource mapper for convenience
        // return the resource - hydra takes care of the rest
        return $this->resourceMapper->map(new ItemResource(), $item);
    }
}
