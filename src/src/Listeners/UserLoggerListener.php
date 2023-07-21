<?php

namespace App\Listeners;

use App\Model\TimeLoggerInterface;
use App\Model\UserLoggerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class UserLoggerListener
{
    private $tokenStorage;
    public function  __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage =$tokenStorage;
    }
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // If this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof UserLoggerInterface) {
            return;
        }
        $token =$this->tokenStorage->getToken();
        $user = $token==null? null:$this->tokenStorage->getToken()->getUser();
        $entity->setUpdatedUser($user);
        $entity->setCreatedUser($user);


        // ... do something with the entity
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        // If this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof UserLoggerInterface) {
            return;
        }
        $token =$this->tokenStorage->getToken();
        $user = $token==null? null:$this->tokenStorage->getToken()->getUser();
        $entity->setUpdatedUser($user);
         }
}