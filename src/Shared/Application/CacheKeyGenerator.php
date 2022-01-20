<?php

declare(strict_types=1);

namespace XcelirateQuote\Shared\Application;

final class CacheKeyGenerator
{
    public function generate(string ...$data): string
    {
        $key = mb_strtolower(implode('.', $data));

        $key = preg_replace('/\s+/', '_', $key);

        $key = preg_replace('/[^a-zA-Z0-9_\.]/u', '', $key);

        return $key;
    }
}
