<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\TimestampEntity;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

final class DoctrineTimestampSubscriber implements EventSubscriber
{
    public function prePersist(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof TimestampEntity) {
            $datetime = new DateTime();
            $entity
                ->setCreatedAt(DateTimeImmutable::createFromMutable($datetime))
                ->setUpdatedAt($datetime);
        }
    }

    /**
     * @return array<int, string>
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }
}
