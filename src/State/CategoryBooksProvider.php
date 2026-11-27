<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BookRepository;

final readonly class CategoryBooksProvider implements ProviderInterface
{
    public function __construct(
        private BookRepository $bookRepository,
    ) {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->bookRepository->findByCategoryID((int) $uriVariables['id']);
    }
}
