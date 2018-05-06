<?php

use PHPUnit\Framework\TestCase;
use Bank\UseCases\Deposit;

class DepositTest extends TestCase
{
    public function testDepositWhenValueIsGreaterThanZeroShouldSumWithAccountCurrentBalance()
    {
        $validator = new \Bank\Entity\Validator();
        $account = new \Bank\Entity\Account();
        $transaction = new \Bank\Entity\Transaction(50);

        $deposit = new Deposit($account, $transaction, $validator);
        $accountResult = $deposit->deposit();

        $this->assertEquals(50, $accountResult->getCurrentBalance());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be greater than zero
     **/

    public function testDepositWhenValueIsLessOrEqualZeroShouldThrowAnException()
    {
        $validator = new \Bank\Entity\Validator();
        $account = new \Bank\Entity\Account();
        $transaction = new \Bank\Entity\Transaction(-10);

        $deposit = new Deposit($account, $transaction, $validator);
        $deposit->deposit();
    }
}

