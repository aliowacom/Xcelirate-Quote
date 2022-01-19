<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\QuoteApi\Shared\Quote\Domain\QuoteAmount;
use XcelirateQuote\Shared\Application\CacheKeyGenerator;

final class QuoteFinder
{
    public function __construct(
        private QuoteRepository $repository, 
        private CacheKeyGenerator $generator,
        private CacheInterface $cache,
        private int $quoteCacheTimeout,
    ){}
    
    public function findByAuthor(QuoteAuthor $author, QuoteAmount $amount): Quotes
    {
        $cacheKey = $this->generator->generate(
            __FUNCTION__,
            $author->value(),
        );
        
        $quotes = $this->cache->get($cacheKey, function (ItemInterface $item) use($author, $amount) {
            $item->expiresAfter($this->quoteCacheTimeout);
        
            return $this->repository->findByAuthor($author, $amount);
        });

        return $quotes;
    }
}
