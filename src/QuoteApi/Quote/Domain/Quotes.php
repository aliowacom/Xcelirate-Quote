<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Domain;

use XcelirateQuote\Shared\Domain\Collection;

class Quotes extends Collection
{
    protected function type(): string
    {
        return Quote::class;
    }
}
