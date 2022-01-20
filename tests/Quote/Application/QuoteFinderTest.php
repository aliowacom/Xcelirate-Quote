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
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Shared\Application\CacheKeyGenerator;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;

final class QuoteFinderTest extends MockeryTestCase
{
    private QuoteRepository|MockInterface|null $repository;

    protected function shouldFindByAuthor(QuoteAuthor $author): void
    {
        $this->repository()
            ->shouldReceive('findByAuthor')
            ->with($author)
            ->once()
            ->andReturn(new Quotes([]));
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

        $this->shouldFindByAuthor($author);

        $finder->findByAuthor($author);
    }
}
