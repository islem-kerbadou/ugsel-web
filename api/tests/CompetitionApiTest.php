<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionApiTest extends WebTestCase
{
    
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllCompetitions(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/competitions');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateCompetitions(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetCompetitionById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 2',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('GET', "/api/competitions/$id");

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateCompetition(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 3',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/competitions/$id", [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Competition 3 mis a jour', $updated['name']);
    }

    public function testDeleteCompetition(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 4',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/competitions/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
