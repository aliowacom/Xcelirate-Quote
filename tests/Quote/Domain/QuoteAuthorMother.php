<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Domain;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;

final class QuoteAuthorMother
{
    public static function create(string $value): QuoteAuthor
    {
        return new QuoteAuthor($value);
    }
}
