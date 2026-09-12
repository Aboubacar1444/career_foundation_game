<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ReleaseType;
use App\Repository\ReleaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReleaseRepository::class)]
#[ORM\Table(name: '`release`')]
class Release
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Song::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Song $song;

    #[ORM\Column(type: Types::STRING, enumType: ReleaseType::class)]
    private ReleaseType $releaseType;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $releaseAt = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $campaignStatus = 'pending';

    public function __construct(Song $song, ReleaseType $releaseType)
    {
        $this->song = $song;
        $this->releaseType = $releaseType;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): Song
    {
        return $this->song;
    }

    public function getReleaseType(): ReleaseType
    {
        return $this->releaseType;
    }

    public function getReleaseAt(): ?\DateTimeImmutable
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(?\DateTimeImmutable $releaseAt): void
    {
        $this->releaseAt = $releaseAt;
    }

    public function getCampaignStatus(): string
    {
        return $this->campaignStatus;
    }

    public function setCampaignStatus(string $status): void
    {
        $this->campaignStatus = $status;
    }
}
