<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ActionType;
use App\Enum\GameActionStatus;
use App\Repository\GameActionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameActionRepository::class)]
#[ORM\Table(name: 'game_action')]
class GameAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\Column(type: Types::STRING, enumType: ActionType::class)]
    private ActionType $actionType;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $startedAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $expectedCompletionAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $resolvedAt = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $speedReductionSeconds = 0;

    #[ORM\Column(type: Types::STRING, enumType: GameActionStatus::class)]
    private GameActionStatus $status = GameActionStatus::Created;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $payloadJson = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $resultJson = null;

    public function __construct(
        Character $character,
        ActionType $actionType,
        \DateTimeImmutable $startedAt,
        \DateTimeImmutable $expectedCompletionAt,
        ?array $payloadJson = null,
    ) {
        $this->character = $character;
        $this->actionType = $actionType;
        $this->startedAt = $startedAt;
        $this->expectedCompletionAt = $expectedCompletionAt;
        $this->payloadJson = $payloadJson;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getActionType(): ActionType
    {
        return $this->actionType;
    }

    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function getExpectedCompletionAt(): \DateTimeImmutable
    {
        return $this->expectedCompletionAt;
    }

    public function getResolvedAt(): ?\DateTimeImmutable
    {
        return $this->resolvedAt;
    }

    public function getSpeedReductionSeconds(): int
    {
        return $this->speedReductionSeconds;
    }

    public function applySpeedReduction(int $seconds): void
    {
        $this->speedReductionSeconds += $seconds;
        $this->status = GameActionStatus::SpeedModified;
    }

    public function getStatus(): GameActionStatus
    {
        return $this->status;
    }

    public function setStatus(GameActionStatus $status): void
    {
        $this->status = $status;
    }

    public function getPayloadJson(): ?array
    {
        return $this->payloadJson;
    }

    public function getResultJson(): ?array
    {
        return $this->resultJson;
    }

    public function setResultJson(?array $result): void
    {
        $this->resultJson = $result;
    }

    /**
     * TIME_ENGINE.md: effective_completion = min(original_completion - speed_reduction, server_now)
     */
    public function getEffectiveCompletionAt(\DateTimeImmutable $serverNow): \DateTimeImmutable
    {
        $original = $this->expectedCompletionAt;
        $adjusted = $original->modify("-{$this->speedReductionSeconds} seconds");

        return $adjusted < $serverNow ? $adjusted : $serverNow;
    }

    public function resolve(\DateTimeImmutable $serverNow, array $result): void
    {
        $this->resolvedAt = $this->getEffectiveCompletionAt($serverNow);
        $this->resultJson = $result;
        $this->status = GameActionStatus::Resolved;
    }
}
