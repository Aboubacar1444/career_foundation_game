<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EventScope;
use App\Repository\EventDefinitionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventDefinitionRepository::class)]
#[ORM\Table(name: 'event_definition')]
class EventDefinition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, enumType: EventScope::class)]
    private EventScope $scope;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $scheduleRule = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $requirementsJson = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $rewardsJson = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;

    public function __construct(string $code, string $name, EventScope $scope)
    {
        $this->code = $code;
        $this->name = $name;
        $this->scope = $scope;
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

    public function getScope(): EventScope
    {
        return $this->scope;
    }

    public function getScheduleRule(): ?string
    {
        return $this->scheduleRule;
    }

    public function getRequirementsJson(): ?array
    {
        return $this->requirementsJson;
    }

    public function getRewardsJson(): ?array
    {
        return $this->rewardsJson;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
