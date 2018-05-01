<?php

use PHPUnit\Framework\TestCase;
use Bank\Account;
use Bank\Transaction;

class AccountTest extends TestCase
{
    public function testWhenInitializeANewAccountTheValueShouldBeZero()
    {
        $account = new Account();
        $this->assertEquals(0, $account->getCurrentBalance()); 
    }

    public function testDepositShouldSumValueWithCurrentBalance()
    {
        $account = new Account();
        $transaction = new Transaction(100);
        $account->deposit($transaction);
        $this->assertEquals(100, $account->getCurrentBalance()); 
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be greater than zero
     **/
    public function testDepositWhenValueLessThanZeroShouldThrowAnException()
    {
        $account = new Account();
        $transaction = new Transaction(-10);
        $account->deposit($transaction);
    }

    public function testWithDrawWhenAccountContainsTheValueShouldSubtractBalance()
    {
       $account = new Account();
       $depositTransaction = new Transaction(100);
       $withdrawTransaction = new Transaction(30);

       $account->deposit($depositTransaction);
       $account->withdraw($withdrawTransaction);

      $this->assertEquals(70, $account->getCurrentBalance());
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be less than the current balance
     **/
    public function testWithDrawWhenPassValueGreatherThanBalanceShouldThrowAnException()
    {
        $account = new Account();
        $transaction = new Transaction(10);
        $account->withdraw($transaction);
    }


    public function testGetTransactionsWhenInitializeAccountShouldBeAnEmptyArray()
    {
        $account = new Account();
        $this->assertEquals([], $account->getTransactions());
    }

    public function testDepositWhenAfterPassedShouldStoreTransaction()
    {
        $account = new Account();
        $transaction = new Transaction(90);

        $account->deposit($transaction);
        $this->assertContains($transaction, $account->getTransactions());
    }


    public function testWithDrawWhenAfterPassedShouldStoreTransaction()
    {
        $account = new Account();
        $depositTransaction = new Transaction(100);
        $withdrawTransaction = new Transaction(90);

        $account->deposit($depositTransaction);
        $account->withdraw($withdrawTransaction);
        $this->assertContains($withdrawTransaction, $account->getTransactions());
    }


    public function testTransferWhenAnAccountHasSufficientMoneyShouldTransferToOtherAccount()
    {
        $account1 = new Account();
        $depositTransaction = new Transaction(100);

        $account1->deposit($depositTransaction);

        $account2 = new Account();

        $transferTransaction = new Transaction(60);

        $account1->transfer($account2, $transferTransaction);

        $this->assertEquals(40, $account1->getCurrentBalance());
        $this->assertEquals(60, $account2->getCurrentBalance());
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage    The value should be less than the current balance
     **/
    public function testTransferWhenAnAccountHasNotSufficientMoneyShouldThrowAnException()
    {
        $account1 = new Account();
        $depositTransaction = new Transaction(10);

        $account1->deposit($depositTransaction);

        $account2 = new Account();

        $transferTransaction = new Transaction(30);

        $account1->transfer($account2, $transferTransaction);
    }

    public function testTransferWhenAnAccountHasSufficientMoneyShouldStoreTransactionsBothAccounts()
    {
        $account1 = new Account();
        $depositTransaction = new Transaction(100);

        $account1->deposit($depositTransaction);

        $account2 = new Account();

        $transferTransaction = new Transaction(30);

        $account1->transfer($account2, $transferTransaction);


        $this->assertContains($transferTransaction, $account1->getTransactions());
        $this->assertContains($transferTransaction, $account2->getTransactions());
    }


}

