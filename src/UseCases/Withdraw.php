<?php

namespace Bank\UseCases;

class Withdraw 
{
    private $account;
    private $transaction;
    private $validator;

    public function __construct(\Bank\Entity\Account $account, \Bank\Entity\Transaction $transaction, \Bank\Entity\Validator $validator)
    {
        $this->account = $account;
        $this->transaction = $transaction;
        $this->validator = $validator;
    }

    public function withdraw() : \Bank\Entity\Account 
    {
        $this->validator->hasAccountBalanceEnough($this->transaction, $this->account);

        $this->account->subtractCurrentBalance($this->transaction);

        return $this->account;
    }
}

