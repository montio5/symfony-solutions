<?php

namespace App\Model;

interface UserLoggerInterface
{
    public function getCreatedUser(): \App\Entity\User;

    public function setCreatedUser(\App\Entity\User $user): self;

    public function getUpdatedUser(): \App\Entity\User;
    public function setUpdatedUser(\App\Entity\User $user): self;

}