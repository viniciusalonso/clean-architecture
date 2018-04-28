<?php

namespace Bank;

class Account
{
    private $currentBalance;

    public function __construct()
    {
        $this->currentBalance = 0; 
    }

    public function getCurrentBalance()
    {
        return $this->currentBalance; 
    }

    public function deposit(float $value) : void
    {
        if ($value <= 0) {
          throw new  \InvalidArgumentException();
        }

        $this->currentBalance += $value;
    }

    public function withdraw(float $value) : void
    {

        if ($value > $this->currentBalance) {
          throw new   \InvalidArgumentException('The value should be greater than zero');
        }

        $this->currentBalance -= $value;
    }
}
