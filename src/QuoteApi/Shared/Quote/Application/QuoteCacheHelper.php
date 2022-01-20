<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Shared\Quote\Application;

use XcelirateQuote\Shared\Application\CacheHelper;

final class QuoteCacheHelper implements CacheHelper
{
    public function __construct(private int $quoteCacheExpiryTime) {}

    public function generateKey(string ...$data): string
    {
        $key = mb_strtolower(implode('.', $data));

        $key = preg_replace('/\s+/', '_', $key);

        $key = preg_replace('/[^a-zA-Z0-9_\.]/u', '', $key);

        return $key;
    }

    public function getExpiryTime(): int
    {
        return $this->quoteCacheExpiryTime;
    }
}
