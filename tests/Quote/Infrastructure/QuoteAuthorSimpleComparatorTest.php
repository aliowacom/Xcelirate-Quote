<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Quote\Infrastructure\QuoteAuthorSimpleComparator;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;

final class QuoteAuthorSimpleComparatorTest extends TestCase
{
    protected QuoteAuthorSimpleComparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new QuoteAuthorSimpleComparator;
    }

    /** @test */
    public function omits_case_sensitivity_and_special_characters()
    {
        $original = QuoteAuthorMother::create(' John%!%, Doe...');
        $comparable = QuoteAuthorMother::create('Doe(!), ... John!?');

        $this->assertTrue($this->comparator->compare($original, $comparable));
    }

    /** @test */
    public function having_at_least_one_different_word_returns_false()
    {
        $original = QuoteAuthorMother::create('John Doe San');
        $comparable = QuoteAuthorMother::create('John Bon Doe');

        $this->assertFalse($this->comparator->compare($original, $comparable));
    }

    /** @test */
    public function having_all_same_words_returns_true_even_if_coparable_has_more_words()
    {
        $original = QuoteAuthorMother::create('John Doe');
        $comparable = QuoteAuthorMother::create('Jean Clot John Bon Doe');

        $this->assertTrue($this->comparator->compare($original, $comparable));
    }
}
