<?php

namespace App\Entity;

use App\Repository\BookRepository;
use App\State\CategoryBooksProvider;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\Groups as AttributeGroups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/books/{id}', 
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(
            uriTemplate: '/Books',
        ),
        new Post(
            uriTemplate:'/book',
            status: 301
        )
    ],
)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[AttributeGroups(['category:books'])]

    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[AttributeGroups(['category:books'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishAt = null;

    #[ORM\Column(length: 50)]
    #[AttributeGroups(['category:books'])]
    private ?string $author = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPublishAt(): ?\DateTimeImmutable
    {
        return $this->publishAt;
    }

    public function setPublishAt(\DateTimeImmutable $publishAt): static
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }
}
