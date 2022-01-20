<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;

final class QuoteAuthorStrictComparator implements QuoteAuthorComparator
{
    public function compare(QuoteAuthor $original, QuoteAuthor $comparable): bool
    {
        $original = $this->parse($original->value());
        $comparable = $this->parse($comparable->value());

        return $original === $comparable;
    }
    
    public function parse(string $value): array
    {
        $value = mb_strtolower($value);
        $value = preg_replace('/[^\w\s]/u', '', $value);

        $value = array_filter(array_unique(explode(' ', $value)));
        sort($value);

        return array_values($value);
    }
}
