<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionApiTest extends WebTestCase
{
    
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    private function createSport($client): string
    {
        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Test',
        ]));
        $this->assertResponseStatusCodeSame(201);
        $sportData = json_decode($client->getResponse()->getContent(), true);
        return $sportData['@id'] ?? '/api/sports/' . $sportData['id'];
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
        $sportIri = $this->createSport($client);

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 1',
            'sport' => $sportIri,
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetCompetitionById(): void
    {
        $client = static::createClient();
        $sportIri = $this->createSport($client);

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 2',
            'sport' => $sportIri,
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
        $sportIri = $this->createSport($client);

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 3',
            'sport' => $sportIri,
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/competitions/$id", [], [], ['CONTENT_TYPE' => 'application/merge-patch+json'], json_encode([
            'name' => 'Competition 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Competition 3 mis a jour', $updated['name']);
    }

    public function testDeleteCompetition(): void
    {
        $client = static::createClient();
        $sportIri = $this->createSport($client);

        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition 4',
            'sport' => $sportIri,
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/competitions/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
