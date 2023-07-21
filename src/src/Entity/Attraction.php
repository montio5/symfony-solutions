<?php

namespace App\Entity;

use App\Model\TimeLoggerInterface;
use App\Model\TimeLoggerTrait;
use App\Model\UserLoggerInterface;
use App\Model\UserLoggerTrait;
use App\Repository\AttractionRepository;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: AttractionRepository::class)]
class Attraction implements TimeLoggerInterface,UserLoggerInterface
{
    use TimeLoggerTrait;
    use UserLoggerTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $short_desc = null;

    #[ORM\Column(length: 1000)]
    private ?string $full_desc = null;

    #[ORM\Column]
    private ?int $score = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->short_desc;
    }

    public function setShortDesc(?string $short_desc): self
    {
        $this->short_desc = $short_desc;

        return $this;
    }

    public function getFullDesc(): ?string
    {
        return $this->full_desc;
    }

    public function setFullDesc(string $full_desc): self
    {
        $this->full_desc = $full_desc;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
