<?php

declare(strict_types=1);

namespace XcelirateQuote\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use XcelirateQuote\QuoteApi\Quote\Application\ShoutedQuotesService;

class ShoutedQuotesController
{
    public function __construct(private ShoutedQuotesService $service) {}

    #[Route('/shout/{author}', name: 'shout', methods: ["GET"])]
    public function __invoke(Request $request): JsonResponse
    {
        $amount = $request->query->get('limit', 1);
        $author = $request->get('author');

        try{
            $quotes = $this->service->__invoke($author, $amount);
            return new JsonResponse($quotes);

        } catch(\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}