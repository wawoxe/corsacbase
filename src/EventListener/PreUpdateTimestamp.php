<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\TimestampEntity;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(
    event: Events::preUpdate,
    priority: 501,
    connection: 'default',
)]
class PreUpdateTimestamp
{
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof TimestampEntity) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
