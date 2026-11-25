<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Category;
use App\Repository\CategoryRepository;

final readonly class CategoryAlphabeticalProvider implements ProviderInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return $this->categoryRepository->findBy([], ['name' => 'ASC']);
    }
}
