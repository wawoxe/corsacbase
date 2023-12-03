<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository example:
 *
 * final class UserRepository extends Repository
 * {
 *      public function __construct(ManagerRegistry $registry)
 *      {
 *          parent::__construct($registry, User::class);
 *      }
 * }
 */
abstract class Repository extends ServiceEntityRepository implements EntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        protected readonly string $entityClass
    ) {
        parent::__construct($registry, $this->entityClass);
    }

    /**
     * @param object $entity Entity, which should be saved
     * @param bool $flush Flush execution after removing
     */
    public function save(object $entity, bool $flush = false): void
    {
        $this->processEntity($entity, 'persist', $flush);
    }

    /**
     * @param object $entity Entity, which should be removed
     * @param bool $flush Flush execution after removing
     */
    public function remove(object $entity, bool $flush = false): void
    {
        $this->processEntity($entity, 'remove', $flush);
    }

    private function processEntity(object $entity, string $function, bool $flush = false): void
    {
        if ($function === 'persist') {
            $this->getEntityManager()->persist($entity);
        } else {
            $this->getEntityManager()->remove($entity);
        }

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }
}
