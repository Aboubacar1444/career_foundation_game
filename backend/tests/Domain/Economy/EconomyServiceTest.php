<?php

declare(strict_types=1);

namespace App\Tests\Domain\Economy;

use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Entity\Character;
use App\Entity\Player;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Language;
use App\Enum\Sex;
use App\Repository\TransactionRepository;
use App\Domain\Economy\EconomyService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EconomyServiceTest extends TestCase
{
    private TransactionRepository $transactionRepository;
    private EntityManagerInterface $entityManager;
    private EconomyService $economyService;

    protected function setUp(): void
    {
        $this->transactionRepository = $this->createMock(TransactionRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->economyService = new EconomyService(
            $this->transactionRepository,
            $this->entityManager,
        );
    }

    private function createWallet(int $initialBalance = 0): Wallet
    {
        $player = new Player('ext-1');
        $language = new Language('fr', 'French');
        $country = new Country('ML', 'Mali', 'XOF', $language);
        $city = new City($country, 'Bamako', 500000, 0.6);
        $character = new Character($player, 'Amadou', Sex::Male, $country, $city);

        return new Wallet($character, 'XOF', $initialBalance);
    }

    public function testCreditCreatesTransactionRecord(): void
    {
        $wallet = $this->createWallet(1000);

        $transaction = $this->economyService->credit($wallet, 500, 'concert', 42);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertSame('credit', $transaction->getType());
        $this->assertSame(500, $transaction->getAmount());
        $this->assertSame('concert', $transaction->getReferenceType());
        $this->assertSame(42, $transaction->getReferenceId());
        $this->assertSame(1500, $wallet->getBalance());
    }

    public function testDebitCreatesTransactionRecord(): void
    {
        $wallet = $this->createWallet(2000);

        $transaction = $this->economyService->debit($wallet, 300, 'studio', 7);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertSame('debit', $transaction->getType());
        $this->assertSame(-300, $transaction->getAmount());
        $this->assertSame(1700, $wallet->getBalance());
    }

    public function testDebitFailsWithInsufficientBalance(): void
    {
        $wallet = $this->createWallet(100);

        $this->expectException(\LogicException::class);
        $this->economyService->debit($wallet, 500);
    }

    public function testTransferAlwaysCreatesTransaction(): void
    {
        $wallet = $this->createWallet(1000);

        $persisted = [];
        $this->entityManager->method('persist')->willReturnCallback(function ($entity) use (&$persisted) {
            $persisted[] = $entity;
        });

        $this->economyService->credit($wallet, 100);
        $this->economyService->debit($wallet, 50);

        // Every balance change must have a transaction
        $this->assertCount(2, $persisted);
        foreach ($persisted as $entity) {
            $this->assertInstanceOf(Transaction::class, $entity);
        }
    }
}
