<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SongStreamStatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongStreamStatRepository::class)]
#[ORM\Table(name: 'song_stream_stat')]
class SongStreamStat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Song::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Song $song;

    #[ORM\ManyToOne(targetEntity: StreamingPlatform::class)]
    #[ORM\JoinColumn(nullable: false)]
    private StreamingPlatform $streamingPlatform;

    #[ORM\ManyToOne(targetEntity: Market::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Market $market;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $periodStart;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $periodEnd;

    #[ORM\Column(type: Types::BIGINT)]
    private int $streams = 0;

    #[ORM\Column(type: Types::FLOAT)]
    private float $revenue = 0.0;

    public function __construct(
        Song $song,
        StreamingPlatform $streamingPlatform,
        Market $market,
        \DateTimeImmutable $periodStart,
        \DateTimeImmutable $periodEnd,
    ) {
        $this->song = $song;
        $this->streamingPlatform = $streamingPlatform;
        $this->market = $market;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): Song
    {
        return $this->song;
    }

    public function getStreamingPlatform(): StreamingPlatform
    {
        return $this->streamingPlatform;
    }

    public function getMarket(): Market
    {
        return $this->market;
    }

    public function getPeriodStart(): \DateTimeImmutable
    {
        return $this->periodStart;
    }

    public function getPeriodEnd(): \DateTimeImmutable
    {
        return $this->periodEnd;
    }

    public function getStreams(): int
    {
        return $this->streams;
    }

    public function addStreams(int $streams): void
    {
        $this->streams += $streams;
    }

    public function getRevenue(): float
    {
        return $this->revenue;
    }

    public function addRevenue(float $revenue): void
    {
        $this->revenue += $revenue;
    }
}
