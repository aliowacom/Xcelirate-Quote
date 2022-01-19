<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use XcelirateQuote\QuoteApi\Quote\Domain\Quote;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;

interface QuoteTransformer
{
    public function transform(Quote $quote): Quote;

    public function transformMany(Quotes $quotes): Quotes;
}
