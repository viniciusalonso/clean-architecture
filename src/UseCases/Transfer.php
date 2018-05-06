<?php
namespace Bank\UseCases;

use Bank\Entity\Account;
use Bank\Entity\Transaction;
use Bank\Entity\Validator;

class Transfer
{
    private $accountOne;
    private $accountTwo;
    private $transaction;
    private $validator;

    public function __construct(
        Account $accountOne,
        Account $accountTwo,
        Transaction $transaction,
        Validator $validator
    ) {
        $this->accountOne = $accountOne;
        $this->accountTwo = $accountTwo;
        $this->transaction = $transaction;
        $this->validator = $validator;
    }

    public function transfer()
    {
        $this->validator->hasAccountBalanceEnough($this->transaction, $this->accountOne);
        $this->accountOne->subtractCurrentBalance($this->transaction);
        $this->accountTwo->sumCurrentBalance($this->transaction);
    }
}
