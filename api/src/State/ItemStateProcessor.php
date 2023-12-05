<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Item;
use App\ApiResource\Item as ItemResource;
use App\Mapper\EntityMapper;
use App\Repository\ItemRepository;

readonly class ItemStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ItemRepository $itemRepository,
        private ItemStateProvider $itemProvider,
        private EntityMapper $entityMapper
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {
        // check we are dealing with the correct resource
        assert($data instanceof ItemResource);

        // find resource if we can (for PUT/PATCH/DELETE)
        $item = $this->itemRepository->findOneBy($uriVariables);

        // if we are deleting then handle the delete process
        if ($operation instanceof DeleteOperationInterface) {
            if ($item !== null) {
                $this->itemRepository->remove($item);
            }

            return null;
        }

        // if we are posting create a new entity
        if ($operation instanceof Post) {
            $item = new Item();
        }

        // use the repository to persist the entity returned from the mapper
        // you have full control here - the mapper is used for same
        // named resource/entity properties for convenience
        $this->itemRepository->persist($this->entityMapper->map($item, $data));

        // re-affirm the key (for POST) (unique case as we are explicitly setting the identifier)
        $uriVariables['key'] = $data->key;

        // return the item from the provider
        return $this->itemProvider->provide($operation, $uriVariables, $context);
    }
}
