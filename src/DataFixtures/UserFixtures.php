<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository(User::class);

        for ($i = 0; $i < 100; $i++) {
            $isAdmin = (bool) rand(0, 1);

            if ($isAdmin) {
                $roles = ['ROLE_USER', 'ROLE_ADMIN'];
            } else {
                $roles = ['ROLE_USER'];
            }

            $user = (new User())
                ->setEmail('user' . $i . '@example.com')
                ->setPlainPassword('user' . $i)
                ->setRoles($roles);

            $userRepository->save($user);
        }

        $manager->flush();
    }
}
