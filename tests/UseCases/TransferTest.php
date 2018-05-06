<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use Bank\Entity\Account;
use Bank\Entity\Validator;
use Bank\Entity\Transaction;
use Bank\UseCases\Transfer;

class TransferTest extends TestCase
{
    public function testTransferWhenAccountHasSuffientBalanceShouldSubtractValueFirstAccountAndSumToSecondAccount()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(20);

        $accountOne = $this->prophesize(Account::class);
        $accountOne->getCurrentBalance()->willReturn(40);
        $accountOne->subtractCurrentBalance($transaction)->shouldBeCalled();

        $validator = $this->prophesize(Validator::class);
        $validator->hasAccountBalanceEnough($transaction, $accountOne)->shouldBeCalled();

        $accountTwo = $this->prophesize(Account::class);
        $accountTwo->sumCurrentBalance($transaction)->shouldBeCalled();

        $transferService = new Transfer(
            $accountOne->reveal(),
            $accountTwo->reveal(),
            $transaction->reveal(),
            $validator->reveal()
        );
        $transferService->transfer();
    }

    /**
     * @expectedException InvalidArgumentException
     *
     * */
    public function testTransferWhenFirstAccountHasNotSufficientBalanceShouldThrownAnException()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(90);

        $accountOne = $this->prophesize(Account::class);
        $accountOne->getCurrentBalance()->willReturn(40);

        $validator = $this->prophesize(Validator::class);
        $validator->hasAccountBalanceEnough(
            $transaction->reveal(),
            $accountOne->reveal()
        )->will($this->throwException(new \InvalidArgumentException()));

        $accountTwo = $this->prophesize(Account::class);
        $accountTwo->sumCurrentBalance($transaction->reveal());

        $transferService = new Transfer(
            $accountOne->reveal(),
            $accountTwo->reveal(),
            $transaction->reveal(),
            $validator->reveal()
        );

        $transferService->transfer();
    }
}
