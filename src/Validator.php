<?php

namespace Bank;

class Validator
{
    public function isValueGreaterThanZero(Transaction $transaction) : void
    {
        if ($transaction->getValue() <= 0) {
            throw new  \InvalidArgumentException('The value should be greater than zero');
        }
    }

    public function hasAccountBalanceEnough(Transaction $transaction, Account $account) : void
    {
        if ($transaction->getValue() > $account->getCurrentBalance()) {
          throw new \InvalidArgumentException('The value should be less than the current balance');
        }
    }

}
