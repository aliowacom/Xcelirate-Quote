<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Domain;

use XcelirateQuote\QuoteApi\Shared\Quote\Domain\QuoteAmount;

interface QuoteRepository
{
    public function findByAuthor(QuoteAuthor $author, QuoteAmount $amount): Quotes;
}
