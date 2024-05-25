<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $MaxKcal = null;

    #[ORM\Column]
    private ?int $MaxProtein = null;

    #[ORM\Column]
    private ?int $MaxCarbs = null;

    #[ORM\Column]
    private ?int $MaxFat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxKcal(): ?int
    {
        return $this->MaxKcal;
    }

    public function setMaxKcal(int $MaxKcal): static
    {
        $this->MaxKcal = $MaxKcal;

        return $this;
    }

    public function getMaxProtein(): ?int
    {
        return $this->MaxProtein;
    }

    public function setMaxProtein(int $MaxProtein): static
    {
        $this->MaxProtein = $MaxProtein;

        return $this;
    }

    public function getMaxCarbs(): ?int
    {
        return $this->MaxCarbs;
    }

    public function setMaxCarbs(int $MaxCarbs): static
    {
        $this->MaxCarbs = $MaxCarbs;

        return $this;
    }

    public function getMaxFat(): ?int
    {
        return $this->MaxFat;
    }

    public function setMaxFat(int $MaxFat): static
    {
        $this->MaxFat = $MaxFat;

        return $this;
    }
}
