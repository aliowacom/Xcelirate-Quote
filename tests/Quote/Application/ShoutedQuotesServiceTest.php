<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Application;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use XcelirateQuote\QuoteApi\Quote\Application\ShoutedQuotesService;

final class ShoutedQuotesServiceTest extends KernelTestCase
{
    protected ShoutedQuotesService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        $this->service = $container->get(ShoutedQuotesService::class);
    }

    /** @test */
    public function amount_greater_than_allowed_throws_exception()
    {
        $this->expectException(\Exception::class);

        $this->service->__invoke('John Doe', 11);
    }

    /**
     * @test
     * @dataProvider provideInvalidAmount
     */
    public function invalid_amount_throws_exception($amount)
    {
        $this->expectException(\LogicException::class);

        $this->service->__invoke('John Doe', $amount);
    }

    public function provideInvalidAmount()
    {
        $data = [0, '0', -1, 'string'];

        return array_map(fn($val) => [$val, $val], $data);
    }

    /** @test */
    public function returns_exact_amount_of_quotes_of_selected_author()
    {
        $quotes = $this->service->__invoke('John Doe', 1);
        $this->assertCount(1, $quotes);

        $quotes = $this->service->__invoke('John Doe', 2);
        $this->assertCount(2, $quotes);
    }

    /** @test */
    public function returns_shouted_texts_of_quotes_of_selected_author()
    {
        $quotes = $this->service->__invoke('John Doe', 2);

        $this->assertContains('BE COOL!', $quotes);
        $this->assertContains('BE SMART!', $quotes);
        $this->assertNotContains('BE LIKE ME!', $quotes);
    }
}
