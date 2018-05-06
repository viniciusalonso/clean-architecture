<?php

namespace Bank\UseCases;

class Deposit
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

    public function deposit() : \Bank\Entity\Account 
    {
        $this->validator->isValueGreaterThanZero($this->transaction);
        $this->account->sumCurrentBalance($this->transaction);

        return $this->account;
    }
}

