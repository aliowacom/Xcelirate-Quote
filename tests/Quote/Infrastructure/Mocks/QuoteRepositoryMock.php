<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure\Mocks;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Tests\Quote\Domain\QuoteMother;

final class QuoteRepositoryMock implements QuoteRepository
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
            QuoteMother::create(
                'Steve Jobs',
                'Iphone 20.',
            ),
            QuoteMother::create(
                'Steve Jobs',
                'Iphone 2022.',
            ),
        ]);
    }
}
