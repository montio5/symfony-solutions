<?php

namespace App\Listeners;
use App\Model\TimeLoggerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TimeLoggerListener
{
    public function prePersist(  $args): void
    {
        $entity = $args->getObject();

        // If this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof TimeLoggerInterface) {
            return;
        }

        $entity->setCreatedAt(new \DateTimeImmutable());
        $entity->setUpdatedAt(new \DateTimeImmutable());
        // ... do something with the entity
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        // If this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof TimeLoggerInterface) {
            return;
        }

        $entity->setUpdatedAt(new \DateTimeImmutable());
    }
}
