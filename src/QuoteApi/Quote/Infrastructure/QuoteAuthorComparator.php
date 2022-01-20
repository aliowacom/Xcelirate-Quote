<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;

interface QuoteAuthorComparator
{
    public function compare(QuoteAuthor $original, QuoteAuthor $comparable): bool;
}
