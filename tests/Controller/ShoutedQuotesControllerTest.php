<?php

declare(strict_types=1);

namespace XcelirateQuote\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShoutedQuotesControllerTest extends WebTestCase
{
    public int $maxAmount;
    public KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->maxAmount = static::getContainer()->getParameter('app.quote.max_amount');
    }

    /** @test */
    public function valid_params_return_valid_json_response()
    {
        $author = 'john-doe';
        $amount = 1;

        $this->client->request('GET', "/shout/{$author}?limit={$amount}");

        $response = $this->client->getResponse();
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
    }

    /** @test */
    public function amount_greater_than_allowed_returns_400()
    {
        $author = 'john-doe';
        $amount = $this->maxAmount + 1;

        $this->client->request('GET', "/shout/{$author}?limit={$amount}");

        $response = $this->client->getResponse();
        
        $this->assertSame(400, $response->getStatusCode());
    }

    /** @test */
    public function invalid_amount_returns_400()
    {
        $author = 'john-doe';
        $amount = 'invalid-amount';

        $this->client->request('GET', "/shout/{$author}?limit={$amount}");

        $response = $this->client->getResponse();
        
        $this->assertSame(400, $response->getStatusCode());
    }

    /** @test */
    public function returns_json_encoded_shouted_quotes()
    {
        $author = 'john-doe';
        $amount = 2;
        $expectedResult = json_encode(['BE COOL!','BE SMART!']);

        $this->client->request('GET', "/shout/{$author}?limit={$amount}");

        $response = $this->client->getResponse();
        
        $this->assertEquals($expectedResult, $response->getContent());
    }

    /** @test */
    public function sets_amount_to_1_if_not_provided()
    {
        $author = 'john-doe';
        $expectedResult = json_encode(['BE COOL!']);

        $this->client->request('GET', "/shout/{$author}");

        $response = $this->client->getResponse();
        
        $this->assertEquals($expectedResult, $response->getContent());
    }
}
