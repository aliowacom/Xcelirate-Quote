<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Shared\Application;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\QuoteApi\Shared\Quote\Application\QuoteCacheHelper;

final class QuoteCacheHelperTest extends TestCase
{
    private QuoteCacheHelper $helper;

    protected function setUp(): void
    {
        $this->helper = new QuoteCacheHelper(0);
    }

    /** @test */
    public function returns_concatenated_string_separated_with_dot()
    {
        $stringA = 'string1';
        $stringB = 'string2';
        $stringC = 'string3';

        $result = $this->helper->generateKey($stringA, $stringB, $stringC);

        $this->assertEquals('string1.string2.string3', $result);
    }

    /** @test */
    public function transforms_to_snake_case()
    {
        $string = 'word1 word2 word3';

        $result = $this->helper->generateKey($string);

        $this->assertEquals('word1_word2_word3', $result);
    }

    /** @test */
    public function transforms_to_lower_case()
    {
        $string = 'sTRinG';

        $result = $this->helper->generateKey($string);

        $this->assertEquals('string', $result);
    }

    /** @test */
    public function removes_invalid_characters()
    {
        $string = 'start!@#$%^&)(*-><=+[]{}\\|/end';

        $result = $this->helper->generateKey($string);

        $this->assertEquals('startend', $result);
    }

    /** @test */
    public function removes_duplicated_words()
    {
        $string = 'string1 string1';

        $result = $this->helper->generateKey($string);

        $this->assertEquals('string1', $result);
    }

    /** @test */
    public function sorts_words_in_alphabetical_order()
    {
        $string = 'bravo charlie alpha';

        $result = $this->helper->generateKey($string);

        $this->assertEquals('alpha_bravo_charlie', $result);
    }

    /** @test */
    public function returns_correct_expiry_time()
    {
        $helper = new QuoteCacheHelper(1337);

        $this->assertEquals(1337, $helper->getExpiryTime());
    }
}
