<?php

use PHPUnit\Framework\TestCase;
use Bank\Entity\Account;
use Bank\Entity\Transaction;

class AccountTest extends TestCase
{
    public function testGetCurrentBalanceWhenInitializeNewAccountShouldBeZero()
    {
        $account = new Account();
        $this->assertEquals(0, $account->getCurrentBalance());
    }

    public function testGetTransactionsWhenInitializeNewAccountShouldBeAnEmptyArray()
    {
        $account = new Account();
        $this->assertEquals([], $account->getTransactions());
    }

    public function testSumCurrentBalanceWhenPassTransactionShouldSumItsValueWithCurrentBalance()
    {
        $account = new Account();

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(30);

        $account->sumCurrentBalance($transaction->reveal());
        $this->assertEquals(30, $account->getCurrentBalance());
    }

    public function testSumCurrentBalanceWhenPassTransactionShouldStoreTransaction()
    {
        $account = new Account();

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(40);

        $account->sumCurrentBalance($transaction->reveal());

        $this->assertContains($transaction->reveal(), $account->getTransactions());
        $this->assertEquals(1, count($account->getTransactions()));
    }

    public function testSubtractCurrentBalanceWhenPassTransactionShouldSubractItsValueWithCurrentBalance()
    {
        $account = new Account();

        $sumTransaction = $this->prophesize(Transaction::class);
        $sumTransaction->getValue()->willReturn(80);

        $subtractTransaction = $this->prophesize(Transaction::class);
        $subtractTransaction->getValue()->willReturn(30);

        $account->sumCurrentBalance($sumTransaction->reveal());

        $account->subtractCurrentBalance($subtractTransaction->reveal());
        $this->assertEquals(50, $account->getCurrentBalance());
    }

    public function testSubtractCurrentBalanceWhenPassTransactionShouldStoreTransaction()
    {
        $account = new Account();

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(40);

        $account->subtractCurrentBalance($transaction->reveal());

        $this->assertContains($transaction->reveal(), $account->getTransactions());
        $this->assertEquals(1, count($account->getTransactions()));
    }
}

