<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteText;
use XcelirateQuote\QuoteApi\Shared\Quote\Domain\QuoteAmount;

final class FileQuoteRepository implements QuoteRepository
{
    private const FILE_PATH = __DIR__ . '/../../../../assets/';

    private Quotes $quotes;

    public function findByAuthor(QuoteAuthor $author, QuoteAmount $amount): Quotes
    {
        return $this->getQuotes()
                    ->filter(function(Quote $quote) use($author) {
                        return mb_strtolower($quote->author()->value()) == mb_strtolower($author->value());
                    })
                    ->take($amount->value());
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
        return json_decode(file_get_contents(self::FILE_PATH . 'quotes.json'), true);
    }
}
