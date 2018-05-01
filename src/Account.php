<?php

namespace Bank;

class Account
{
    private $currentBalance;
    private $transactions;
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
        $this->currentBalance = 0; 
        $this->transactions = [];
    }

    public function getCurrentBalance()
    {
        return $this->currentBalance; 
    }

    public function deposit(Transaction $transaction) : void
    {
        $this->validator->isValueGreaterThanZero($transaction);
        $this->sumCurrentBalance($transaction);
    }

    public function addTransaction(Transaction $transaction) : void
    {
        $this->transactions[] = $transaction;
    }

    public function withdraw(Transaction $transaction) : void
    {
        $this->validator->hasAccountBalanceEnough($transaction, $this);
        $this->subtractCurrentBalance($transaction);
    }

    public function getTransactions() : array
    {
        return $this->transactions;
    }

    public function  sumCurrentBalance(Transaction $transaction) : void
    {
        $this->currentBalance += $transaction->getValue();
        $this->addTransaction($transaction);
    }

    public function  subtractCurrentBalance(Transaction $transaction) : void
    {
        $this->currentBalance -= $transaction->getValue();
        $this->addTransaction($transaction);
    }

    public function transfer(Account $account, Transaction $transaction) : void
    {
        $this->validator->hasAccountBalanceEnough($transaction, $this);
        $this->subtractCurrentBalance($transaction);
        $account->sumCurrentBalance($transaction);
    }
}
