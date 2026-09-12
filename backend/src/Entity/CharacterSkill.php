<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterSkillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterSkillRepository::class)]
#[ORM\Table(name: 'character_skill')]
#[ORM\UniqueConstraint(name: 'unique_character_skill', columns: ['character_id', 'skill_id'])]
class CharacterSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\ManyToOne(targetEntity: Skill::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Skill $skill;

    #[ORM\Column(type: Types::INTEGER)]
    private int $value = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct(Character $character, Skill $skill, int $value = 0)
    {
        $this->character = $character;
        $this->skill = $skill;
        $this->value = min($value, $skill->getMaxValue());
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

    public function getSkill(): Skill
    {
        return $this->skill;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = min($value, $this->skill->getMaxValue());
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
