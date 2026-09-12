<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProfessionalGradeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionalGradeRepository::class)]
#[ORM\Table(name: 'professional_grade')]
class ProfessionalGrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    private int $rankOrder;

    #[ORM\Column(type: Types::INTEGER)]
    private int $minLevel;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;

    public function __construct(string $code, string $name, int $rankOrder, int $minLevel)
    {
        $this->code = $code;
        $this->name = $name;
        $this->rankOrder = $rankOrder;
        $this->minLevel = $minLevel;
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

    public function getRankOrder(): int
    {
        return $this->rankOrder;
    }

    public function getMinLevel(): int
    {
        return $this->minLevel;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
