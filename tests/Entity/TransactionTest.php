<?php

namespace Tests\Entity;

use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testGetValueWhenHasAValueShouldReturnIt()
    {
        $transaction = new \Bank\Entity\Transaction(14.09);
        $this->assertEquals(14.09, $transaction->getValue());
    }
}
