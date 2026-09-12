<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StreamingPlatformRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StreamingPlatformRepository::class)]
#[ORM\Table(name: 'streaming_platform')]
class StreamingPlatform
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
    private string $platformType;

    public function __construct(string $code, string $name, string $platformType)
    {
        $this->code = $code;
        $this->name = $name;
        $this->platformType = $platformType;
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

    public function getPlatformType(): string
    {
        return $this->platformType;
    }
}
