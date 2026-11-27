<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\State\CategoryAlphabeticalProvider;
use App\State\CategoryBooksProvider;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\Groups as AttributeGroups;
use ApiPlatform\Metadata\Link;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\Parameter;
use ApiPlatform\OpenApi\Model\Response;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/category/{id}',
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(
            uriTemplate: '/categories',
        ),
        new GetCollection(
            uriTemplate: '/categories/alphabetical',
            provider: CategoryAlphabeticalProvider::class,
            normalizationContext: ['groups' => ['category:alphabetical']],
            outputFormats: ['json' => ['application/json']],
        ),
        new GetCollection(
            uriTemplate: '/categories/{id}/books',
            uriVariables: ['id' => new Link(fromClass: Category::class)],
            output: Book::class,
            provider: CategoryBooksProvider::class,
            normalizationContext: ['groups' => ['category:books']],
            outputFormats: ['json' => ['application/json']],
        ),
        new Post(
            uriTemplate: '/category',
            status: 301
        )
    ],
    order: ['id' => 'ASC', 'name' => 'ASC'],
    paginationEnabled: false
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[AttributeGroups(['category:alphabetical'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: false)]
    #[AttributeGroups(['category:alphabetical'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
