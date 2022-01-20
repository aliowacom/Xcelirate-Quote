<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Quote\Application;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Cache\Adapter\NullAdapter;
use XcelirateQuote\QuoteApi\Quote\Application\QuoteFinder;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Shared\Application\CacheHelper;
use XcelirateQuote\Tests\Quote\Domain\QuoteAuthorMother;

final class QuoteFinderTest extends MockeryTestCase
{
    private CacheHelper|MockInterface|null $cacheHelper;
    private QuoteRepository|MockInterface|null $repository;

    protected function shouldGenerateKey(): void
    {
        $this->cacheHelper()
            ->shouldReceive('generateKey')
            ->once();
    }

    protected function shouldGetExpiryTime(): void
    {
        $this->cacheHelper()
            ->shouldReceive('getExpiryTime')
            ->once();
    }

    protected function shouldFindByAuthor(QuoteAuthor $author): void
    {
        $this->repository()
            ->shouldReceive('findByAuthor')
            ->with($author)
            ->once()
            ->andReturn(new Quotes([]));
    }

    protected function cacheHelper(): CacheHelper|MockInterface
    {
        return $this->cacheHelper = $this->cacheHelper ?? Mockery::mock(CacheHelper::class);
    }

    protected function repository(): QuoteRepository|MockInterface
    {
        return $this->repository = $this->repository ?? Mockery::mock(QuoteRepository::class);
    }

    /** @test */
    public function should_find_quotes()
    {
        $finder = new QuoteFinder(
            $this->repository(),
            new NullAdapter,
            $this->cacheHelper(),
        );
        
        $author = QuoteAuthorMother::create('author');

        $this->shouldGenerateKey();
        $this->shouldGetExpiryTime();
        $this->shouldFindByAuthor($author);

        $finder->findByAuthor($author);
    }
}
