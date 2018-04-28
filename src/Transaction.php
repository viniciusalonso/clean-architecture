<?php

namespace Bank;

class Transaction
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue() : float
    {
        return $this->value;
    }

}
