<?php

namespace App\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\User;

class BookTest extends TestCase
{
    public function testGetTitleReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Alice au pays des merveilles";
        //assigner une valeur dans $title
        $book->setTitle($expect);
        //2 Act
        $actual = $book->getTitle();
        //3 Assert
        self::assertSame($expect, $actual);
    }

    public function testGetResumeReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Un livre qui raconte l'histoire d'Alice au pays des merveilles";
        //assigner une valeur dans $resume
        $book->setResume($expect);
        //2 Act
        $actual = $book->getResume();
        //3 Assert
        self::assertSame($expect, $actual);
    }

    public function testGetAuthorReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Lewis Carrol";
        //assigner une valeur dans $author
        $book->setAuthor($expect);
        //2 Act
        $actual = $book->getAuthor();
        //3 Assert
        self::assertSame($expect, $actual);
    }

    public function testGetPublishAtReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = new \DateTimeImmutable();
        //assigner une valeur dans $publishAt
        $book->setPublishAt($expect);
        //2 Act
        $actual = $book->getPublishAt();
        //3 Assert
        self::assertSame($expect, $actual);
    }

    public function testGetTitleNotReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Alice au pays des merveilles";
        //Value set dans $title
        $value = "Le tour du monde en 80 jours";
        //assigner une valeur dans $title
        $book->setTitle($value);
        //2 Act
        $actual = $book->getTitle();
        //3 Assert
        self::assertNotSame($expect, $actual);
    }


    public function testGetResumeNotReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Un livre qui raconte l'histoire du tour du monde en 80 jours";
        //Value set dans $resume
        $value = "Un livre qui raconte l'histoire d'Alice au pays des merveilles";
        //assigner une valeur dans $resume
        $book->setResume($value);
        //2 Act
        $actual = $book->getResume();
        //3 Assert
        self::assertNotSame($expect, $actual);
    }

    public function testGetAuthorNotReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = "Lewis Carrol";
        //Value set dans $author
        $value = "Victor Hugo";
        //assigner une valeur dans $author
        $book->setAuthor($value);
        //2 Act
        $actual = $book->getAuthor();
        //3 Assert
        self::assertNotSame($expect, $actual);
    }

    public function testGetPublishAtNotReturnExpectedValue(): void
    {
        //1 Arrange
        $book = new Book();
        $expect = new \DateTimeImmutable();
        //Value set dans $publishAt
        $value = new \DateTimeImmutable('2025-01-01');
        //assigner une valeur dans $publishAt
        $book->setPublishAt($value);
        //2 Act
        $actual = $book->getPublishAt();
        //3 Assert
        self::assertNotSame($expect, $actual);
    }
    public function testAddCategoryStoresTheCategoryInstance(): void
    {
        // Arrange
        $book = new Book();
        $category = new Category();
        $expected = [$category];

        // Act
        $book->addCategory($category);

        // Assert
        $actual = $book->getCategories()->toArray();
        self::assertSame($expected, $actual);
    }
    public function testAddCategoryDoesNotDuplicateTheSameInstance(): void
    {
        // Arrange
        $book = new Book();
        $category = new Category();

        // Act
        $book->addCategory($category);
        $book->addCategory($category);

        // Assert
        self::assertCount(1, $book->getCategories());
    }
    public function testAddTwoDifferentCategoryInstances(): void
    {
        // Arrange
        $book = new Book();
        $category1 = new Category();
        $category2 = new Category();
        $expected = [$category1, $category2];

        // Act
        $book->addCategory($category1);
        $book->addCategory($category2);

        // Assert
        $actual = $book->getCategories()->toArray();
        self::assertCount(2, $book->getCategories());
        self::assertContains($category1, $actual);
        self::assertContains($category2, $actual);
    }
}
