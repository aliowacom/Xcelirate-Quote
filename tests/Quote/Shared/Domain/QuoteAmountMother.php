<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Shared\Domain;

use XcelirateQuote\QuoteApi\Shared\Quote\Domain\QuoteAmount;

final class QuoteAmountMother
{
    public static function create(int $value): QuoteAmount
    {
        return new QuoteAmount($value);
    }
}
