<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;

final class QuotesSerializer
{
    public function toTextArray(Quotes $quotes): array
    {
        $result = [];

        foreach($quotes as $quote) {
            $result[] = $quote->text()->value();
        }

        return $result;
    }
}
