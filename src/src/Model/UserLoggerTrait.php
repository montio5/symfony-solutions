<?php

namespace App\Model;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
trait UserLoggerTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $createdUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    protected $updatedUser;

    public function getCreatedUser(): \App\Entity\User
    {
        return $this->createdUser;
    }

    public function setCreatedUser(?\App\Entity\User $createdUser): self
    {
        $this->createdUser = $createdUser;
        return $this;
    }

    public function getUpdatedUser(): \App\Entity\User
    {
        return $this->updatedUser;

    }

    public function setUpdatedUser(?\App\Entity\User $updatedUser): self
    {
        $this->updatedUser = $updatedUser;
        return $this;
    }
}