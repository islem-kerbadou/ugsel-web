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
        $client->request('GET', '/api/competitions.jsonld', [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateCompetition(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/competitions.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Competition 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetCompetitionById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Competition 2',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('GET', "/api/competitions/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateCompetition(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Competition 3',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('PATCH', "/api/competitions/$id.jsonld", [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Competition 3 mis à jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Competition 3 mis à jour', $updated['name']);
    }

    public function testDeleteCompetition(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/competitions.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Competition 4',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('DELETE', "/api/competitions/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}