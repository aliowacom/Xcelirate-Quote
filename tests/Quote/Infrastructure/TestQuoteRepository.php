<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Tests\Quote\Domain\QuoteMother;

final class TestQuoteRepository implements QuoteRepository
{
    public function findByAuthor(QuoteAuthor $author): Quotes
    {
        return $this->getQuotes()
                    ->filter(function(Quote $quote) use($author) {
                        return mb_strtolower($quote->author()->value()) == mb_strtolower($author->value());
                    });
    }

    private function getQuotes(): Quotes
    {
        return new Quotes([
            QuoteMother::create(
                'John Doe',
                'Be cool.',
            ),
            QuoteMother::create(
                'Jane Doe',
                'Be like me.',
            ),
            QuoteMother::create(
                'John Doe',
                'Be smart.',
            ),
        ]);
    }
}
