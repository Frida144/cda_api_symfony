<?php
namespace App\Tests\Unit\Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends Testcase
{
    public function testGetTitleReturnGoodValue(): void
    {
        $testBook = new Book();
        $value = "test title";
        $testBook->setTitle($value);
        $result = $testBook->getTitle();
        self::assertSame($value, $result);

    }
    public function testGetTitleReturnBadValue(): void
    {
        $testBook = new Book();
        $result = "test title";
        $value = "test title 2";
        $testBook->setTitle($value);
        $result = $testBook->getTitle();
        self::assertNotSame($value, $result);
    }
    public function testGetResumeReturnGoodValue(): void
    {
        $testBook = new Book();
        $value = "test resume";
        $testBook->setResume($value);
        $result = $testBook->getResume();
        self::assertSame($value, $result);

    }
    public function testGetResumeReturnBadValue(): void
    {
        $testBook = new Book();
        $result = "test resume";
        $value = "test resume 2";
        $testBook->setResume($value);
        $result = $testBook->getResume();
        self::assertNotSame($value, $result);
    }
    public function testGetAuthorReturnGoodValue(): void
    {
        $testBook = new Book();
        $value = "test author";
        $testBook->setAuthor($value);
        $result = $testBook->getAuthor();
        self::assertSame($value, $result);

    }
    public function testGetAuthorReturnBadValue(): void
    {
        $testBook = new Book();
        $result = "test author";
        $value = "test author 2";
        $testBook->setAuthor($value);
        $result = $testBook->getAuthor();
        self::assertNotSame($value, $result);
    }
    public function testGetPublishAtReturnGoodValue(): void
    {
        $testBook = new Book();
        $value = new \DateTimeImmutable("2024-01-01");
        $testBook->setPublishAt($value);
        $result = $testBook->getPublishAt();
        self::assertSame($value, $result);

    }
    public function testGetPublishAtReturnBadValue(): void
    {
        $testBook = new Book();
        $result = new \DateTimeImmutable("2024-01-01");
        $value = new \DateTimeImmutable("2024-01-02");
        $testBook->setPublishAt($value);
        $result = $testBook->getPublishAt();
        self::assertNotSame($value, $result);
    }
    public function testSetTitleWithArrayThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $testBook = new Book();
        $testBook->setTitle(['test title']);
    }
    public function testSetResumeWithArrayThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $testBook = new Book();
        $testBook->setResume(['test resume']);
    }
    public function testSetAuthorWithArrayThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $testBook = new Book();
        $testBook->setAuthor(['test author']);
    }
    public function testSetPublishAtWithStringThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $testBook = new Book();
        $testBook->setPublishAt('2024-01-01');
    }
}