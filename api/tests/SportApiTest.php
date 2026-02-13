<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportApiTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllSportTypes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/sport_types.jsonld', [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSportType(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_1',
            'label' => 'Sport Type 1'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetSportTypeById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_2',
            'label' => 'Sport Type 2'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('GET', "/api/sport_types/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateSportType(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_3',
            'label' => 'Sport Type 3'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('PATCH', "/api/sport_types/$id.jsonld", [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'label' => 'Sport Type 3 mis à jour'
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Sport Type 3 mis à jour', $updated['label']);
    }

    public function testDeleteSportType(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_4',
            'label' => 'Sport Type 4'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $data);
        $iri = $data['@id'];
        $id = basename($iri);

        $client->request('DELETE', "/api/sport_types/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}