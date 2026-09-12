<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
#[ORM\Table(name: 'song')]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Genre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Genre $primaryGenre;

    #[ORM\Column(type: Types::FLOAT)]
    private float $qualityScore;

    #[ORM\Column(type: Types::FLOAT)]
    private float $originalityScore;

    #[ORM\Column(type: Types::FLOAT)]
    private float $commercialPotential;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status = 'draft';

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Character $character,
        string $title,
        Genre $primaryGenre,
        float $qualityScore,
        float $originalityScore,
        float $commercialPotential,
    ) {
        $this->character = $character;
        $this->title = $title;
        $this->primaryGenre = $primaryGenre;
        $this->qualityScore = $qualityScore;
        $this->originalityScore = $originalityScore;
        $this->commercialPotential = $commercialPotential;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrimaryGenre(): Genre
    {
        return $this->primaryGenre;
    }

    public function getQualityScore(): float
    {
        return $this->qualityScore;
    }

    public function getOriginalityScore(): float
    {
        return $this->originalityScore;
    }

    public function getCommercialPotential(): float
    {
        return $this->commercialPotential;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
