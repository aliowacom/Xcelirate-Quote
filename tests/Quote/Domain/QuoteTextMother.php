<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Domain;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteText;

final class QuoteTextMother
{
    public static function create(string $value): QuoteText
    {
        return new QuoteText($value);
    }
}
