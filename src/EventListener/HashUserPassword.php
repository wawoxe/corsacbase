<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(
    event: Events::prePersist,
    method: 'prePersist',
    entity: User::class,
    priority: 500,
)]
final class HashUserPassword
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function prePersist(User $user): void
    {
        // Hash User password
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
        // Clear User's $plainPassword
        $user->eraseCredentials();
    }
}
