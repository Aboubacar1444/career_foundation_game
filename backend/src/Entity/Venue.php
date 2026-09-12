<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VenueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenueRepository::class)]
#[ORM\Table(name: 'venue')]
class Venue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(nullable: false)]
    private City $city;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $capacity;

    #[ORM\Column(type: Types::INTEGER)]
    private int $tier;

    public function __construct(City $city, string $name, int $capacity, int $tier)
    {
        $this->city = $city;
        $this->name = $name;
        $this->capacity = $capacity;
        $this->tier = $tier;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getTier(): int
    {
        return $this->tier;
    }
}
