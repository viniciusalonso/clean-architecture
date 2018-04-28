<?php

namespace Bank;

class Account
{
    private $currentBalance;
    private $transactions;

    public function __construct()
    {
        $this->currentBalance = 0; 
        $this->transactions = [];
    }

    public function getCurrentBalance()
    {
        return $this->currentBalance; 
    }

    public function deposit(Transaction $transaction) : void
    {
        if ($transaction->getValue() <= 0) {
          throw new  \InvalidArgumentException('The value should be greater than zero');
        }

        $this->currentBalance += $transaction->getValue();
        $this->addTransaction($transaction);
    }

    private function addTransaction(Transaction $transaction) : void
    {
        $this->transactions[] = $transaction;
    }

    public function withdraw(Transaction $transaction) : void
    {

        if ($transaction->getValue() > $this->currentBalance) {
          throw new   \InvalidArgumentException('The value should be less than the current balance');
        }

        $this->currentBalance -= $transaction->getValue();
        $this->addTransaction($transaction);
    }

    public function getTransactions() : array
    {
        return $this->transactions;
    }
}
