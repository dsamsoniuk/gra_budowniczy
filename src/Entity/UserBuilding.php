<?php

namespace App\Entity;

use App\Repository\UserBuildingRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBuildingRepository::class)]
class UserBuilding
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBuildings')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userBuildings')]
    private ?Building $building = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column]
    private ?DateTime $createTime = null;

    #[ORM\Column]
    private ?DateTime $finishTime = null;
    
    public function __construct(){

        $this->status = 'construction';
        $this->createTime = new DateTime();
    }
    public static function getStatusList(){
        return [ 
            'w budowie' => 'construction',
            'wybudowany' => 'finished'
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): static
    {
        $this->building = $building;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateTime(): ?\DateTime
    {
        return $this->createTime;
    }

    public function setCreateTime(\DateTime $createTime): static
    {
        $this->createTime = $createTime;

        return $this;
    }

    public function getFinishTime(): ?\DateTime
    {
        return $this->finishTime;
    }

    public function setFinishTime(\DateTime $finishTime): static
    {
        $this->finishTime = $finishTime;

        return $this;
    }

}
