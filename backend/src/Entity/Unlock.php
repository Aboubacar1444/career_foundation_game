<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UnlockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnlockRepository::class)]
#[ORM\Table(name: 'unlock')]
class Unlock
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
    private string $type;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $requirementsJson = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;

    public function __construct(string $code, string $name, string $type, ?array $requirementsJson = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->type = $type;
        $this->requirementsJson = $requirementsJson;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function getRequirementsJson(): ?array
    {
        return $this->requirementsJson;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
