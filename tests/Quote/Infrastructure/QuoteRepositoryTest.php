<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;
use XcelirateQuote\Tests\Quote\Shared\Domain\QuoteAmountMother;

trait QuoteRepositoryTest
{
    private QuoteRepository $repository;

    abstract protected function getRepositoryClass(): string;

    abstract protected function getRepositoryArguments(): array;

    protected function setUp(): void
    {
        $class = $this->getRepositoryClass();
        $this->repository = new $class(...$this->getRepositoryArguments());

        parent::setUp();
    }

    /** @test */
    public function returns_quotes_with_given_author()
    {
        $author = QuoteAuthorMother::create('Steve Jobs');
        $amount = QuoteAmountMother::create(5);

        $quotes = $this->repository->findByAuthor($author, $amount);

        $this->assertGreaterThan(0, count($quotes));
        foreach($quotes as $quote) {
            $this->assertEquals($quote->author()->value(), 'Steve Jobs');
        }
    }

    /** @test */
    public function returns_requested_amount_of_quotes()
    {
        $author = QuoteAuthorMother::create('Steve Jobs');

        $amount = QuoteAmountMother::create(1);
        $quotes = $this->repository->findByAuthor($author, $amount);

        $this->assertEquals(1, count($quotes));

        $amount = QuoteAmountMother::create(5);
        $quotes = $this->repository->findByAuthor($author, $amount);

        $this->assertGreaterThan(1, count($quotes));
    }

    /** @test */
    public function returns_empty_collection_if_not_found()
    {
        $author = QuoteAuthorMother::create('Non-existant Author');
        $amount = QuoteAmountMother::create(5);

        $quotes = $this->repository->findByAuthor($author, $amount);

        $this->assertCount(0, $quotes);
    }
}
