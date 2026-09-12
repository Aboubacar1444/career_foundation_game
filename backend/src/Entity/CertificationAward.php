<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CertificationAwardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificationAwardRepository::class)]
#[ORM\Table(name: 'certification_award')]
class CertificationAward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: CertificationDefinition::class)]
    #[ORM\JoinColumn(nullable: false)]
    private CertificationDefinition $certificationDefinition;

    #[ORM\ManyToOne(targetEntity: Song::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Song $song = null;

    #[ORM\ManyToOne(targetEntity: Release::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Release $release = null;

    #[ORM\ManyToOne(targetEntity: Market::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Market $market = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $awardedAt;

    public function __construct(
        Character $character,
        CertificationDefinition $certificationDefinition,
    ) {
        $this->character = $character;
        $this->certificationDefinition = $certificationDefinition;
        $this->awardedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getCertificationDefinition(): CertificationDefinition
    {
        return $this->certificationDefinition;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): void
    {
        $this->song = $song;
    }

    public function getRelease(): ?Release
    {
        return $this->release;
    }

    public function setRelease(?Release $release): void
    {
        $this->release = $release;
    }

    public function getMarket(): ?Market
    {
        return $this->market;
    }

    public function setMarket(?Market $market): void
    {
        $this->market = $market;
    }

    public function getAwardedAt(): \DateTimeImmutable
    {
        return $this->awardedAt;
    }
}
