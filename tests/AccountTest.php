<?php

use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testWhenInitializeANewAccountTheValueShouldBeZero()
    {
        $account = new \Bank\Account();
        $this->assertEquals(0, $account->getCurrentBalance()); 
    }

    public function testDepositShouldSumValueWithCurrentBalance()
    {
        $account = new \Bank\Account();
        $account->deposit(100);
        $this->assertEquals(100, $account->getCurrentBalance()); 
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value shoulde greater than zero
     **/
    public function testDepositWhenValueLessThanZeroShouldThrowAnException()
    {
        $account = new \Bank\Account();
        $account->deposit(-10);
    }
}

