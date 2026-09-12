<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterMarketAudienceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterMarketAudienceRepository::class)]
#[ORM\Table(name: 'character_market_audience')]
#[ORM\UniqueConstraint(name: 'unique_char_market_seg', columns: ['character_id', 'market_id', 'segment_id'])]
class CharacterMarketAudience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: Market::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Market $market;

    #[ORM\ManyToOne(targetEntity: AudienceSegment::class)]
    #[ORM\JoinColumn(nullable: false)]
    private AudienceSegment $segment;

    #[ORM\Column(type: Types::BIGINT)]
    private int $fans = 0;

    #[ORM\Column(type: Types::FLOAT)]
    private float $engagementScore = 0.0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(Character $character, Market $market, AudienceSegment $segment)
    {
        $this->character = $character;
        $this->market = $market;
        $this->segment = $segment;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getMarket(): Market
    {
        return $this->market;
    }

    public function getSegment(): AudienceSegment
    {
        return $this->segment;
    }

    public function getFans(): int
    {
        return $this->fans;
    }

    public function addFans(int $fans): void
    {
        $this->fans += $fans;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function removeFans(int $fans): void
    {
        $this->fans = max(0, $this->fans - $fans);
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getEngagementScore(): float
    {
        return $this->engagementScore;
    }

    public function setEngagementScore(float $score): void
    {
        $this->engagementScore = $score;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
