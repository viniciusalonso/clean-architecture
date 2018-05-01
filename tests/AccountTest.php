<?php

use PHPUnit\Framework\TestCase;
use Bank\Account;
use Bank\Transaction;
use Bank\Validator;

class AccountTest extends TestCase
{
    public function testWhenInitializeANewAccountTheValueShouldBeZero()
    {
        $validator = $this->prophesize(Validator::class);
        $account = new Account($validator->reveal());
        $this->assertEquals(0, $account->getCurrentBalance()); 
    }

    public function testDepositShouldSumValueWithCurrentBalance()
    {
        $transaction = new Transaction(100);

        $validator = $this->prophesize(Validator::class);
        $validator->isValueGreaterThanZero($transaction)->shouldBeCalled();

        $account = new Account($validator->reveal());
        $account->deposit($transaction);

        $this->assertEquals(100, $account->getCurrentBalance()); 
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be greater than zero
     **/
    public function testDepositWhenValueLessThanZeroShouldThrowAnException()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(-10);

        $validator = new Validator();

        $account = new Account($validator);
        $account->deposit($transaction->reveal());
    }

    public function testWithDrawWhenAccountContainsTheValueShouldSubtractBalance()
    {
       $validator = $this->prophesize(Validator::class);

       $depositTransaction = new Transaction(100);

       $validator->isValueGreaterThanZero($depositTransaction)->shouldBeCalled();

       $account = new Account($validator->reveal());

       $withdrawTransaction = new Transaction(30);

       $validator->hasAccountBalanceEnough($withdrawTransaction, $account)->shouldBeCalled();

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
        $validator = new Validator();
        $account = new Account($validator);

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(10);

        $account->withdraw($transaction->reveal());
    }


    public function testGetTransactionsWhenInitializeAccountShouldBeAnEmptyArray()
    {
        $validator = new Validator();
        $account = new Account($validator);
        $this->assertEquals([], $account->getTransactions());
    }

    public function testDepositWhenAfterPassedShouldStoreTransaction()
    {
        $validator = $this->prophesize(Validator::class);
        $account = new Account($validator->reveal());
        $transaction = new Transaction(90);

        $account->deposit($transaction);
        $this->assertContains($transaction, $account->getTransactions());
        $this->assertEquals(1, count($account->getTransactions()));
    }


    public function testWithDrawWhenAfterPassedShouldStoreTransaction()
    {
        $validator = $this->prophesize(Validator::class);
        $account = new Account($validator->reveal());
        $depositTransaction = new Transaction(100);
        $withdrawTransaction = new Transaction(90);

        $account->deposit($depositTransaction);
        $account->withdraw($withdrawTransaction);

        $this->assertContains($withdrawTransaction, $account->getTransactions());
        $this->assertEquals(2, count($account->getTransactions()));
    }


    public function testTransferWhenAnAccountHasSufficientMoneyShouldTransferToOtherAccount()
    {
        $validator = $this->prophesize(Validator::class);

        $account1 = new Account($validator->reveal());
        $depositTransaction = new Transaction(100);

        $account1->deposit($depositTransaction);

        $account2 = new Account($validator->reveal());

        $transferTransaction = new Transaction(60);

        $account1->transfer($account2, $transferTransaction);

        $this->assertEquals(40, $account1->getCurrentBalance());
        $this->assertEquals(60, $account2->getCurrentBalance());
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be less than the current balance
     **/
    public function testTransferWhenAnAccountHasNotSufficientMoneyShouldThrowAnException()
    {
        $validator = new Validator();

        $account1 = new Account($validator);
        $depositTransaction = new Transaction(10);

        $account1->deposit($depositTransaction);

        $account2 = new Account($validator);

        $transferTransaction = new Transaction(30);

        $account1->transfer($account2, $transferTransaction);
    }

    public function testTransferWhenAnAccountHasSufficientMoneyShouldStoreTransactionsBothAccounts()
    {
        $validator = new Validator();
        $account1 = new Account($validator);
        $depositTransaction = new Transaction(100);

        $account1->deposit($depositTransaction);

        $account2 = new Account($validator);
        $transferTransaction = new Transaction(30);

        $account1->transfer($account2, $transferTransaction);

        $this->assertContains($transferTransaction, $account1->getTransactions());
        $this->assertContains($transferTransaction, $account2->getTransactions());


        $this->assertEquals(2,count($account1->getTransactions()));
        $this->assertEquals(1,count($account2->getTransactions()));
    }
}

