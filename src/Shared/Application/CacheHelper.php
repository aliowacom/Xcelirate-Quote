<?php

declare(strict_types=1);

namespace XcelirateQuote\Shared\Application;

interface CacheHelper
{
    public function generateKey(string ...$data): string;

    public function getExpiryTime(): int;
}
