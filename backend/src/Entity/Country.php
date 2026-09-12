<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'country')]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 10, unique: true)]
    private string $code;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $currencyCode;

    #[ORM\ManyToOne(targetEntity: Language::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Language $defaultLanguage;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;

    public function __construct(string $code, string $name, string $currencyCode, Language $defaultLanguage)
    {
        $this->code = $code;
        $this->name = $name;
        $this->currencyCode = $currencyCode;
        $this->defaultLanguage = $defaultLanguage;
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

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getDefaultLanguage(): Language
    {
        return $this->defaultLanguage;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
