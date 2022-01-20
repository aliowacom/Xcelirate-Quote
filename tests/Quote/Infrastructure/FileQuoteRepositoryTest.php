<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Infrastructure\FileQuoteRepository;

final class FileQuoteRepositoryTest extends TestCase
{
    use QuoteRepositoryTest;

    protected function getRepositoryClass(): string
    {
        return FileQuoteRepository::class;
    }

    protected function getRepositoryArguments(): array
    {
        $path = __DIR__ . '/../../../assets/';
        return [$path];
    }
}
