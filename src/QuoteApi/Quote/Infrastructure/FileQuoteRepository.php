<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteText;

final class FileQuoteRepository implements QuoteRepository
{
    public function __construct(
        private QuoteAuthorComparator $comparator,
        private string $assetsPath
    ) {}
    
    private Quotes $quotes;

    public function findByAuthor(QuoteAuthor $author): Quotes
    {
        return $this->getQuotes()
                    ->filter(function(Quote $quote) use($author) {
                        return $this->comparator->compare($author, $quote->author());
                    });
    }

    private function getQuotes(): Quotes
    {
        if(isset($this->quotes)) {
            return $this->quotes;
        }

        $quotes = $this->fromFile();

        $quotes = array_map(
            fn($quote) => new Quote(
                new QuoteAuthor($quote['author']),
                new QuoteText($quote['quote']),
            ),
            $quotes['quotes']
        );

        $this->quotes = new Quotes($quotes);

        return $this->quotes;
    }

    private function fromFile(): array
    {
        return json_decode(file_get_contents($this->assetsPath . 'quotes.json'), true);
    }
}
