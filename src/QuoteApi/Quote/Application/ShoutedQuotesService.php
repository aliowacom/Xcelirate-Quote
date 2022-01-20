<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use LogicException;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;

final class ShoutedQuotesService
{
    public function __construct(
        private QuoteFinder $finder,
        private QuoteTransformer $shoutTransformer,
        private QuotesSerializer $serializer,
        private int $quoteMaxAmount,
    ){}

    public function __invoke(string $author, int|string $quoteAmount): array
    {
        $quoteAmount = (int)$quoteAmount;
        if($quoteAmount < 1) {
            throw new LogicException('Quote amount must be greater than zero');
        }
        if($quoteAmount > $this->quoteMaxAmount) {
            throw new \Exception('Quote amount is greater than 10');
        }

        $author = preg_replace('/[_\-]+/', ' ', $author);
        $author = new QuoteAuthor($author);

        $quotes = $this->finder
                        ->findByAuthor($author)
                        ->take($quoteAmount);

        $shoutedQuotes = $this->shoutTransformer
                              ->transformMany($quotes);

        return $this->serializer
                    ->toTextArray($shoutedQuotes);
    }
}
