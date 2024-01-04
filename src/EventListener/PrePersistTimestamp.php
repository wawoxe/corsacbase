<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\TimestampEntity;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(
    event: Events::prePersist,
    priority: 501,
    connection: 'default',
)]
class PrePersistTimestamp
{
    public function prePersist(PrePersistEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof TimestampEntity) {
            $datetime = new DateTime();
            $entity
                ->setCreatedAt(DateTimeImmutable::createFromMutable($datetime))
                ->setUpdatedAt($datetime);
        }
    }
}
