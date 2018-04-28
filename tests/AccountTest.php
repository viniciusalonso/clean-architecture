<?php

use PHPUnit\Framework\TestCase;
use Bank\Account;

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
        $account->deposit(100);
        $this->assertEquals(100, $account->getCurrentBalance()); 
    }


    /**
     * @expectedException InvalidArgumentException
     **/
    public function testDepositWhenValueLessThanZeroShouldThrowAnException()
    {
        $account = new Account();
        $account->deposit(-10);
    }

    public function testWithDrawWhenAccountContainsTheValueShouldSubtractBalance()
    {
       $account = new Account();
       $account->deposit(100);
       $account->withdraw(30);

      $this->assertEquals(70, $account->getCurrentBalance());
    }


    /**
     * @expectedException InvalidArgumentException
     **/
    public function testWithDrawWhenPassValueGreatherThanBalanceShouldThrowAnException()
    {
        $account = new Account();
        $account->withdraw(10);
    }
}

