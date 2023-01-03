<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $finished = null;

    #[ORM\ManyToMany(targetEntity: Summoner::class, mappedBy: 'games')]
    private Collection $summoners;

    public function __construct() {
        $this->summoners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * @return Collection<int, Summoner>
     */
    public function getSummoners(): Collection
    {
        return $this->summoners;
    }

    public function addSummoner(Summoner $summoner): self
    {
        if (!$this->summoners->contains($summoner)) {
            $this->summoners->add($summoner);
            $summoner->addGame($this);
        }

        return $this;
    }

    public function removeSummoner(Summoner $summoner): self
    {
        if ($this->summoners->removeElement($summoner)) {
            $summoner->removeGame($this);
        }

        return $this;
    }
}
