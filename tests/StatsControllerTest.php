<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatsControllerTest extends WebTestCase
{
    public function testGetStatsEndpoint(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/stats');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('visitors', $responseData);
        $this->assertArrayHasKey('registrations', $responseData);

        $this->assertIsNumeric($responseData['visitors']);
        $this->assertIsNumeric($responseData['registrations']);
    }
}
