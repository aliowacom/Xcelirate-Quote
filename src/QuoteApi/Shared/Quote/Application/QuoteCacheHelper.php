<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Shared\Quote\Application;

use XcelirateQuote\Shared\Application\CacheHelper;

final class QuoteCacheHelper implements CacheHelper
{
    public function __construct(private int $quoteCacheExpiryTime) {}

    public function generateKey(string ...$data): string
    {
        $data = array_map(fn($string) => $this->prepareString($string), $data);

        $key = implode('.', $data);

        return $key;
    }

    public function getExpiryTime(): int
    {
        return $this->quoteCacheExpiryTime;
    }

    private function prepareString(string $string): string
    {
        $string = mb_strtolower($string);
        $string = preg_replace('/[^a-zA-Z0-9_\s]/u', '', $string);

        $string = array_filter(array_unique(explode(' ', $string)));
        sort($string);

        return implode('_', $string);
    }
}
