<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Application;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteAuthor;
use XcelirateQuote\QuoteApi\Quote\Domain\QuoteRepository;
use XcelirateQuote\QuoteApi\Quote\Domain\Quotes;
use XcelirateQuote\Shared\Application\CacheHelper;

final class QuoteFinder
{
    public function __construct(
        private QuoteRepository $repository, 
        private CacheInterface $cache,
        private CacheHelper $quoteCacheHelper,
    ){}
    
    public function findByAuthor(QuoteAuthor $author): Quotes
    {
        $cacheKey = $this->quoteCacheHelper->generateKey(
            __FUNCTION__,
            $author->value(),
        );
        
        $quotes = $this->cache->get($cacheKey, function (ItemInterface $item) use($author) {
            $item->expiresAfter($this->quoteCacheHelper->getExpiryTime());
        
            return $this->repository->findByAuthor($author);
        });

        return $quotes;
    }
}
