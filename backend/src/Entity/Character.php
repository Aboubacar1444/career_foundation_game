<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\Sex;
use App\Repository\CharacterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Player $player;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $firstName;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $stageName = null;

    #[ORM\Column(type: Types::STRING, enumType: Sex::class)]
    private Sex $sex;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Country $originCountry;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(nullable: false)]
    private City $homeCity;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(
        Player $player,
        string $firstName,
        Sex $sex,
        Country $originCountry,
        City $homeCity,
    ) {
        $this->player = $player;
        $this->firstName = $firstName;
        $this->sex = $sex;
        $this->originCountry = $originCountry;
        $this->homeCity = $homeCity;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getStageName(): ?string
    {
        return $this->stageName;
    }

    public function setStageName(?string $stageName): void
    {
        $this->stageName = $stageName;
    }

    public function getSex(): Sex
    {
        return $this->sex;
    }

    public function getOriginCountry(): Country
    {
        return $this->originCountry;
    }

    public function getHomeCity(): City
    {
        return $this->homeCity;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
