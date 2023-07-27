<?php

namespace App\Listeners;

use App\Model\UserLoggerInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserLoggerListener
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof UserLoggerInterface) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $user = $token == null ? null : $this->tokenStorage->getToken()->getUser();

        $entity->setCreatedUser($user);
        $entity->setUpdatedUser($user);

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof UserLoggerInterface) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        $user = $token == null ? null : $this->tokenStorage->getToken()->getUser();

        $entity->setUpdatedUser($user);
    }
}