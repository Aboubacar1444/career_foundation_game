<?php

declare(strict_types=1);

namespace App\Domain\Economy;

use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;

class EconomyService
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Invariant #1: Money changes are transaction-backed.
     * Every balance mutation creates a corresponding Transaction record.
     */
    public function transfer(
        Wallet $wallet,
        string $type,
        int $amount,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): Transaction {
        $transaction = new Transaction($wallet, $type, $amount);
        $transaction->setReferenceType($referenceType);
        $transaction->setReferenceId($referenceId);

        if ($amount > 0) {
            $wallet->credit($amount);
        } else {
            $wallet->debit(abs($amount));
        }

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }

    /**
     * Credit wallet — wraps transfer with positive amount.
     */
    public function credit(Wallet $wallet, int $amount, ?string $referenceType = null, ?int $referenceId = null): Transaction
    {
        return $this->transfer($wallet, 'credit', $amount, $referenceType, $referenceId);
    }

    /**
     * Debit wallet — wraps transfer with negative amount.
     */
    public function debit(Wallet $wallet, int $amount, ?string $referenceType = null, ?int $referenceId = null): Transaction
    {
        return $this->transfer($wallet, 'debit', -$amount, $referenceType, $referenceId);
    }
}
