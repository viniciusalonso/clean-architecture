<?php

namespace Tests\Entity;

use PHPUnit\Framework\TestCase;
use Bank\Entity\Validator;
use Bank\Entity\Transaction;
use Bank\Entity\Account;

class ValidatorTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be greater than zero
     * */
    public function testIsValueGreaterThanZeroWhenTransactionValueIsGreeatherThanZeroShouldThrowAnException()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(-10);

        $validator = new Validator();
        $validator->isValueGreaterThanZero($transaction->reveal());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage The value should be less than the current balance
     * */

    public function testHasAccountBalanceEnoughWhenAccountHasNotBalanceShouldThrownAnException()
    {
        $transaction = $this->prophesize(Transaction::class);
        $transaction->getValue()->willReturn(50);

        $account = $this->prophesize(Account::class);
        $account->getCurrentBalance()->willReturn(30);

        $validator = new Validator();
        $validator->hasAccountBalanceEnough($transaction->reveal(), $account->reveal());
    }
}
