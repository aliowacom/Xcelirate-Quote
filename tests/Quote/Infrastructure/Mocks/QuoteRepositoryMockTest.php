<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure\Mocks;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\Tests\Quote\Infrastructure\QuoteRepositoryTest;

final class QuoteRepositoryMockTest extends TestCase
{
    use QuoteRepositoryTest;

    protected function getRepository(): QuoteRepository
    {
        return new QuoteRepositoryMock;
    }
}
