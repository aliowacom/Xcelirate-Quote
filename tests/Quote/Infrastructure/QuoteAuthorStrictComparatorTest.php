<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Infrastructure\QuoteAuthorStrictComparator;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;

final class QuoteAuthorStrictComparatorTest extends TestCase
{
    protected QuoteAuthorStrictComparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new QuoteAuthorStrictComparator;
    }
    
    /** @test */
    public function omits_case_sensitivity_and_special_characters()
    {
        $original = QuoteAuthorMother::create(' John%!%, Doe...');
        $comparable = QuoteAuthorMother::create('Doe(!), ... John!?');

        $this->assertTrue($this->comparator->compare($original, $comparable));
    }

    /** @test */
    public function not_matching_with_all_words_returns_false()
    {
        $original = QuoteAuthorMother::create('John Doe');
        $comparable = QuoteAuthorMother::create('John Bon Doe');

        $this->assertFalse($this->comparator->compare($original, $comparable));
    }

    /** @test */
    public function having_all_same_unique_words_as_comparator_returns_true()
    {
        $original = QuoteAuthorMother::create('John Doe John Doe Bon');
        $comparable = QuoteAuthorMother::create('John Bon Doe');

        $this->assertTrue($this->comparator->compare($original, $comparable));
    }
}
