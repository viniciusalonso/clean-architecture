<?php

use PHPUnit\Framework\TestCase;
use Bank\Entity\Validator;
use Bank\Entity\Account;
use Bank\UseCases\Withdraw;
use Bank\Entity\Transaction;

class WithdrawTest extends TestCase
{
    public function testWithdrawWhenValueIsLessOrEqualThanAccountBalanceShouldSubtractValue()
    {

        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(60);

        $account = $this->prophesize(Account::class);
        $account->subtractCurrentBalance($transaction)->shouldBeCalled();

        $validator = $this->prophesize(Validator::class);
        $validator->hasAccountBalanceEnough($transaction, $account)->shouldBeCalled();

        $withdrawService = new Withdraw($account->reveal(), $transaction->reveal(), $validator->reveal());
        $resultAccount = $withdrawService->withdraw();

    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be less than the current balance
     * */
    public function testWithdrawWhenValueIsGreatherThanAccountBalanceShouldThrowAnException()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(60);

        $account = $this->prophesize(Account::class);
        $account->getCurrentBalance()->willReturn(30);

        $exceptionMessage = 'The value should be less than the current balance';
        $validator = $this->prophesize(Validator::class);
        $validator->hasAccountBalanceEnough($transaction, $account)->will($this->throwException(new \InvalidArgumentException()));

        $withdrawService = new Withdraw($account->reveal(), $transaction->reveal(), $validator->reveal());
        $resultAccount = $withdrawService->withdraw();
    }

}

