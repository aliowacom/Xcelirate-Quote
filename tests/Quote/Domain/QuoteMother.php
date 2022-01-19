<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Domain;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;

final class QuoteMother
{
    public static function create(string $author, string $text): Quote
    {
        return Quote::create(
            QuoteAuthorMother::create($author),
            QuoteTextMother::create($text),
        );
    }
}
