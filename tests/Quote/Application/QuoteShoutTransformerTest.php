<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Application;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Application\QuoteShoutTransformer;
use XcelirateQuote\Tests\Quote\Domain\QuoteMother;

final class QuoteShoutTransformerTest extends TestCase
{
    protected QuoteShoutTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new QuoteShoutTransformer;
    }

    /** @test */
    public function transforms_quote_text_to_uppercase()
    {
        $quote = QuoteMother::create('John Doe', 'sample QuOte TEXT!');

        $shoutedQuote = $this->transformer->transform($quote);

        $this->assertEquals($shoutedQuote->text()->value(), 'SAMPLE QUOTE TEXT!');
    }

    /** @test */
    public function replaces_end_of_each_sentence_punctuation_with_exclamation_mark()
    {
        $quote = QuoteMother::create('John Doe', 'SAMPLE. QUOTE? TEXT.?!');

        $shoutedQuote = $this->transformer->transform($quote);

        $this->assertEquals($shoutedQuote->text()->value(), 'SAMPLE! QUOTE! TEXT!');
    }

    /** @test */
    public function adds_exclamation_mark_if_there_is_no_end_of_sentence_punctuation()
    {
        $quote = QuoteMother::create('John Doe', 'SAMPLE QUOTE TEXT');

        $shoutedQuote = $this->transformer->transform($quote);

        $this->assertEquals($shoutedQuote->text()->value(), 'SAMPLE QUOTE TEXT!');
    }
}
