<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Application;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use XcelirateQuote\QuoteApi\Quote\Application\QuoteFinder;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Shared\Quote\Domain\QuoteAmount;
use XcelirateQuote\Shared\Application\CacheKeyGenerator;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;
use XcelirateQuote\Tests\Quote\Shared\Domain\QuoteAmountMother;

final class QuoteFinderTest extends MockeryTestCase
{
    private QuoteRepository|MockInterface|null $repository;

    protected function shouldFindByAuthor(QuoteAuthor $author, QuoteAmount $amount): void
    {
        $this->repository()
            ->shouldReceive('findByAuthor')
            ->with($author, $amount)
            ->once();
    }

    protected function repository(): QuoteRepository|MockInterface
    {
        return $this->repository = $this->repository ?? Mockery::mock(QuoteRepository::class);
    }

    /** @test */
    public function it_should_find_by_author()
    {
        $finder = new QuoteFinder(
            $this->repository(),
            new CacheKeyGenerator,
            new FilesystemAdapter(),
            15
        );
        $author = QuoteAuthorMother::create('author');
        $amount = QuoteAmountMother::create(5);

        $this->shouldFindByAuthor($author, $amount);

        $finder->findByAuthor($author, $amount);
    }
}
