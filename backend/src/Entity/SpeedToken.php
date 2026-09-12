<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SpeedTokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeedTokenRepository::class)]
#[ORM\Table(name: 'speed_token')]
class SpeedToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $speedType;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity = 0;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $sourceType;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $acquiredAt;

    public function __construct(Character $character, string $speedType, int $quantity, string $sourceType)
    {
        $this->character = $character;
        $this->speedType = $speedType;
        $this->quantity = $quantity;
        $this->sourceType = $sourceType;
        $this->acquiredAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getSpeedType(): string
    {
        return $this->speedType;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function consume(int $amount): void
    {
        if ($amount > $this->quantity) {
            throw new \LogicException('Not enough speed tokens.');
        }
        $this->quantity -= $amount;
    }

    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    public function getAcquiredAt(): \DateTimeImmutable
    {
        return $this->acquiredAt;
    }
}
