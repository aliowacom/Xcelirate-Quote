<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Domain;

interface QuoteRepository
{
    public function findByAuthor(QuoteAuthor $author): Quotes;
}
