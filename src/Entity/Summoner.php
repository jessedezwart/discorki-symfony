<?php

namespace App\Entity;

use App\Repository\SummonerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummonerRepository::class)]
class Summoner
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $accountId = null;

    #[ORM\Column]
    private ?int $profileIconId = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $revisionDate = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $puuid = null;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'summoners')]
    #[ORM\JoinTable(name: 'summoner_game')]
    private Collection $games;

    public function __construct() {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getProfileIconId(): ?int
    {
        return $this->profileIconId;
    }

    public function setProfileIconId(int $profileIconId): self
    {
        $this->profileIconId = $profileIconId;

        return $this;
    }

    public function getRevisionDate(): ?string
    {
        return $this->revisionDate;
    }

    public function setRevisionDate(string $revisionDate): self
    {
        $this->revisionDate = $revisionDate;

        return $this;
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

    public function getPuuid(): ?string
    {
        return $this->puuid;
    }

    public function setPuuid(string $puuid): self
    {
        $this->puuid = $puuid;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->addSummoner($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            $game->removeSummoner($this);
        }

        return $this;
    }
}
