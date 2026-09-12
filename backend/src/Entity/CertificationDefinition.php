<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CertificationDefinitionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificationDefinitionRepository::class)]
#[ORM\Table(name: 'certification_definition')]
class CertificationDefinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $releaseType;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $thresholdType;

    #[ORM\Column(type: Types::BIGINT)]
    private int $thresholdValue;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $marketScope;

    public function __construct(
        string $code,
        string $name,
        string $releaseType,
        string $thresholdType,
        int $thresholdValue,
        string $marketScope,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->releaseType = $releaseType;
        $this->thresholdType = $thresholdType;
        $this->thresholdValue = $thresholdValue;
        $this->marketScope = $marketScope;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseType(): string
    {
        return $this->releaseType;
    }

    public function getThresholdType(): string
    {
        return $this->thresholdType;
    }

    public function getThresholdValue(): int
    {
        return $this->thresholdValue;
    }

    public function getMarketScope(): string
    {
        return $this->marketScope;
    }
}
