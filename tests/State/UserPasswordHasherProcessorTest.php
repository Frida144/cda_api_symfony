<?php

namespace App\Tests\State;

use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\State\UserPasswordHasherProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserPasswordHasherProcessorTest extends TestCase
{
    public function testItHashesThePasswordBeforePersistingTheUser(): void
    {
        $operation = new Post();
        $user = (new User())
            ->setEmail('test@example.com')
            ->setPassword('plain-password');

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher
            ->expects(self::once())
            ->method('hashPassword')
            ->with($user, 'plain-password')
            ->willReturn('hashed-password');

        $persistProcessor = $this->createMock(ProcessorInterface::class);
        $persistProcessor
            ->expects(self::once())
            ->method('process')
            ->with($user, $operation, [], [])
            ->willReturn($user);

        $processor = new UserPasswordHasherProcessor($persistProcessor, $passwordHasher);

        self::assertSame($user, $processor->process($user, $operation));
        self::assertSame('hashed-password', $user->getPassword());
    }
}
