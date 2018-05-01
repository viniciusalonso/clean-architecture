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

    public function addTransaction(Transaction $transaction) : void
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

    public function  sumBalance(Transaction $transaction) : void
    {
        $this->currentBalance += $transaction->getValue();
    }

    public function transfer(Account $account, Transaction $transaction) : void
    {

        if ($transaction->getValue() > $this->currentBalance) {
          throw new   \InvalidArgumentException('The value should be less than the current balance');
        }
        $this->currentBalance -= $transaction->getValue();
        $account->sumBalance($transaction);

        $this->addTransaction($transaction);
        $account->addTransaction($transaction);
    }
}
