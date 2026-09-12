<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterUnlockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterUnlockRepository::class)]
#[ORM\Table(name: 'character_unlock')]
#[ORM\UniqueConstraint(name: 'unique_character_unlock', columns: ['character_id', 'unlock_id'])]
class CharacterUnlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: Unlock::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Unlock $unlock;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $unlockedAt;

    public function __construct(Character $character, Unlock $unlock)
    {
        $this->character = $character;
        $this->unlock = $unlock;
        $this->unlockedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getUnlock(): Unlock
    {
        return $this->unlock;
    }

    public function getUnlockedAt(): \DateTimeImmutable
    {
        return $this->unlockedAt;
    }
}
