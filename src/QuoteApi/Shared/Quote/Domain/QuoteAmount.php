<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Shared\Quote\Domain;

use LogicException;
use XcelirateQuote\Shared\Domain\ValueObject\IntValueObject;

final class QuoteAmount extends IntValueObject
{
    public function __construct(int $value)
    {
        $this->ensureIsValidAmount($value);

        parent::__construct($value);
    }

    public function ensureIsValidAmount(int $value)
    {
        if($value < 1) {
            throw new LogicException('Quote amount must be greater than zero');
        }
    }
}
