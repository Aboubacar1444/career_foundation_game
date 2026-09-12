<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\Table(name: 'wallet')]
#[ORM\UniqueConstraint(name: 'unique_wallet_currency', columns: ['character_id', 'currency_code'])]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Character::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Character $character;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $currencyCode;

    #[ORM\Column(type: Types::BIGINT)]
    private int $balance = 0;

    public function __construct(Character $character, string $currencyCode, int $initialBalance = 0)
    {
        $this->character = $character;
        $this->currencyCode = $currencyCode;
        $this->balance = $initialBalance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * Economy invariant: all balance changes must go through transaction-backed operations.
     * This method is internal; external code must use EconomyService::transfer().
     */
    public function credit(int $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Credit amount must be non-negative.');
        }
        $this->balance += $amount;
    }

    /**
     * Economy invariant: all balance changes must go through transaction-backed operations.
     * This method is internal; external code must use EconomyService::transfer().
     */
    public function debit(int $amount): void
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Debit amount must be non-negative.');
        }
        if ($amount > $this->balance) {
            throw new \LogicException('Insufficient balance.');
        }
        $this->balance -= $amount;
    }
}
