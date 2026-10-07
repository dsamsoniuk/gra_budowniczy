<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $buildTime = null;

    #[ORM\Column]
    private ?int $goldCost = null;

    /**
     * @var Collection<int, UserBuilding>
     */
    #[ORM\OneToMany(targetEntity: UserBuilding::class, mappedBy: 'building')]
    private Collection $userBuildings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    public function __construct()
    {
        $this->userBuildings = new ArrayCollection();
    }
    public function __tostring(){
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBuildTime(): ?int
    {
        return $this->buildTime;
    }

    public function setBuildTime(int $buildTime): static
    {
        $this->buildTime = $buildTime;

        return $this;
    }

    public function getGoldCost(): ?int
    {
        return $this->goldCost;
    }

    public function setGoldCost(int $goldCost): static
    {
        $this->goldCost = $goldCost;

        return $this;
    }

    /**
     * @return Collection<int, UserBuilding>
     */
    public function getUserBuildings(): Collection
    {
        return $this->userBuildings;
    }

    public function addUserBuilding(UserBuilding $userBuilding): static
    {
        if (!$this->userBuildings->contains($userBuilding)) {
            $this->userBuildings->add($userBuilding);
            $userBuilding->setBuilding($this);
        }

        return $this;
    }

    public function removeUserBuilding(UserBuilding $userBuilding): static
    {
        if ($this->userBuildings->removeElement($userBuilding)) {
            // set the owning side to null (unless already changed)
            if ($userBuilding->getBuilding() === $this) {
                $userBuilding->setBuilding(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }
}
