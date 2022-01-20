<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Infrastructure\FileQuoteRepository;

final class FileQuoteRepositoryTest extends TestCase
{
    use QuoteRepositoryTest;

    protected function getRepository(): QuoteRepository
    {
        return new FileQuoteRepository(__DIR__ . '/../../../assets/');
    }
}
