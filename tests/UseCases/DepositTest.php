<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use Bank\UseCases\Deposit;
use Bank\Entity\Validator;
use Bank\Entity\Account;
use Bank\Entity\Transaction;

class DepositTest extends TestCase
{
    public function testDepositWhenValueIsGreaterThanZeroShouldSumWithAccountCurrentBalance()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(50);

        $validator = $this->prophesize(Validator::class);
        $validator->isValueGreaterThanZero($transaction->reveal())->shouldBeCalled();

        $account = new Account();

        $deposit = new Deposit(
            $account,
            $transaction->reveal(),
            $validator->reveal()
        );
        $accountResult = $deposit->deposit();

        $this->assertEquals(50, $accountResult->getCurrentBalance());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be greater than zero
     **/

    public function testDepositWhenValueIsLessOrEqualZeroShouldThrowAnException()
    {

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(-10);

        $validator = $this->prophesize(Validator::class);
        $validator->isValueGreaterThanZero($transaction->reveal())
            ->will($this->throwException(new \InvalidArgumentException()));


        $account = $this->prophesize(Account::class);

        $deposit = new Deposit(
            $account->reveal(),
            $transaction->reveal(),
            $validator->reveal()
        );
        $deposit->deposit();
    }
}
