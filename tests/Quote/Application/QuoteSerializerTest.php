<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Application;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Application\QuotesSerializer;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Tests\Quote\Domain\QuoteMother;

final class QuoteSerializerTest extends TestCase
{
    protected QuotesSerializer $serializer;

    protected function setUp(): void
    {
        $this->serializer = new QuotesSerializer;
    }

    /** @test */
    public function toTextArray_returns_array_of_texts()
    {
        $quotes = new Quotes([
            QuoteMother::create('authorA', 'quoteA'),
            QuoteMother::create('authorB', 'quoteB'),
            QuoteMother::create('authorC', 'quoteC'),
        ]);

        $result = $this->serializer->toTextArray($quotes);

        $this->assertCount(3, $result);
        $this->assertEquals('quoteA', $result[0]);
        $this->assertEquals('quoteB', $result[1]);
        $this->assertEquals('quoteC', $result[2]);
    }

    /** @test */
    public function passing_empty_quotes_returns_empty_array()
    {
        $quotes = new Quotes([]);

        $result = $this->serializer->toTextArray($quotes);

        $this->assertCount(0, $result);
        $this->assertCount(0, $result);
    }
}
