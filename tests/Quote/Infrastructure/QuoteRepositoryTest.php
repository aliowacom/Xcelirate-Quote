<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Infrastructure;

use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;

trait QuoteRepositoryTest
{
    private QuoteRepository $repository;

    abstract protected function getRepository(): QuoteRepository;

    protected function setUp(): void
    {
        $this->repository = $this->getRepository();

        parent::setUp();
    }

    /** @test */
    public function returns_quotes_with_given_author()
    {
        $author = QuoteAuthorMother::create('Steve Jobs');

        $quotes = $this->repository->findByAuthor($author);

        $this->assertGreaterThan(0, count($quotes));
        foreach($quotes as $quote) {
            $this->assertEquals($quote->author()->value(), 'Steve Jobs');
        }
    }

    /** @test */
    public function returns_empty_collection_if_not_found()
    {
        $author = QuoteAuthorMother::create('Non-existant Author');

        $quotes = $this->repository->findByAuthor($author);

        $this->assertCount(0, $quotes);
    }
}
