<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteText;

final class QuoteShoutTransformer implements QuoteTransformer
{
    public function transform(Quote $quote): Quote
    {
        $text = $quote->text()->value();

        $text = mb_strtoupper($text);

        $text = preg_replace('/([\.\?\!]+)/u', '!', $text);

        if(mb_substr($text, -1) !== '!') {
            $text = $text . '!';
        }

        $quoteText = new QuoteText($text);

        return new Quote($quote->author(), $quoteText);
    }

    public function transformMany(Quotes $quotes): Quotes
    {
        return $quotes->map(
            fn(Quote $quote) => $this->transform($quote),
            $quotes
        );
    }
}
