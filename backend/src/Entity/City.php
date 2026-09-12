<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ORM\Table(name: 'city')]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $marketSize;

    #[ORM\Column(type: Types::FLOAT)]
    private float $costIndex;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;

    public function __construct(Country $country, string $name, int $marketSize, float $costIndex)
    {
        $this->country = $country;
        $this->name = $name;
        $this->marketSize = $marketSize;
        $this->costIndex = $costIndex;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMarketSize(): int
    {
        return $this->marketSize;
    }

    public function getCostIndex(): float
    {
        return $this->costIndex;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
