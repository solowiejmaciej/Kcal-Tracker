<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface; 


#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Kcal = null;

    #[ORM\Column]
    private ?int $Protein = null;

    #[ORM\Column]
    private ?int $Fat = null;

    #[ORM\Column]
    private ?int $Carbs = null;

    #[ORM\Column]
    private ?string $Section = null;

    #[ORM\Column]
    private ?string $Name = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $ConsumptionDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKcal(): ?int
    {
        return $this->Kcal;
    }

    public function setKcal(int $Kcal): static
    {
        $this->Kcal = $Kcal;

        return $this;
    }

    public function getProtein(): ?int
    {
        return $this->Protein;
    }

    public function setProtein(int $Protein): static
    {
        $this->Protein = $Protein;

        return $this;
    }

    public function getFat(): ?int
    {
        return $this->Fat;
    }

    public function setFat(int $Fat): static
    {
        $this->Fat = $Fat;

        return $this;
    }

    public function getCarbs(): ?int
    {
        return $this->Carbs;
    }

    public function setCarbs(int $Carbs): static
    {
        $this->Carbs = $Carbs;

        return $this;
    }
    
    public function getSection(): ?string
    {
        return $this->Section;
    }
    
    public function setSection(string $Section): static
    {
        $this->Section = $Section;
        
        return $this;
    }
    
    public function getName(): ?string
    {
        return $this->Name;
    }
    
    public function setName(string $Name): static
    {
        $this->Name = $Name;
        
        return $this;
    }

    public function getConsumptionDate(): ?DateTimeInterface
    {
        return $this->ConsumptionDate;
    }

    public function setConsumptionDate(DateTimeInterface $ConsumptionDate): static
    {
        $this->ConsumptionDate = $ConsumptionDate;

        return $this;
    }
    
}
