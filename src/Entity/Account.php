<?php

namespace Bank\Entity;

class Account
{
    private $currentBalance;
    private $transactions;

    public function __construct()
    {
        $this->currentBalance = 0; 
        $this->transactions = [];
    }

    public function getCurrentBalance() : int
    {
        return $this->currentBalance; 
    }

    public function addTransaction(Transaction $transaction) : void
    {
        $this->transactions[] = $transaction;
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

}
