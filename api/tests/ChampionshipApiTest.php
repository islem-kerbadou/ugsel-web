<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionshipApiTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllChampionships(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/championships.jsonld', [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateChampionship(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/championships.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Championnat 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetChampionshipById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Championnat 2',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('GET', "/api/championships/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateChampionship(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Championnat 3',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('PATCH', "/api/championships/$id.jsonld", [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Championnat 3 mis à jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Championnat 3 mis à jour', $updated['name']);
    }

    public function testDeleteChampionship(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Championnat 4',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('DELETE', "/api/championships/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}