<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Shared\Application;

use PHPUnit\Framework\TestCase;
use XcelirateQuote\Shared\Application\CacheKeyGenerator;

final class CacheKeyGeneratorTest extends TestCase
{
    private CacheKeyGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new CacheKeyGenerator;
    }

    /** @test */
    public function returns_concatenated_string_separated_with_dot()
    {
        $stringA = 'stringA';
        $stringB = 'stringB';
        $stringC = 'stringC';

        $result = $this->generator->generate($stringA, $stringB, $stringC);

        $this->assertEquals('stringA.stringB.stringC', $result);
    }

    /** @test */
    public function transforms_to_snake_case()
    {
        $string = 'word1 word2 word3';

        $result = $this->generator->generate($string);

        $this->assertEquals('word1_word2_word3', $result);
    }

    /** @test */
    public function removes_invalid_characters()
    {
        $string = 'start!@#$%^&)(*-><=+[]{}\\|/end';

        $result = $this->generator->generate($string);

        $this->assertEquals('startend', $result);
    }
}
