<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportTypeApiTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllSports(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/sports.jsonld', [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSport(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_FOR_SPORT_1',
            'label' => 'Sport type pour Sport 1'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportTypeData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportTypeData);
        $sportTypeIri = $sportTypeData['@id'];

        $client->request('POST', '/api/sports.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Sport 1',
            'sportType' => $sportTypeIri
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetSportById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_FOR_SPORT_2',
            'label' => 'Sport type pour Sport 2'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportTypeData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportTypeData);
        $sportTypeIri = $sportTypeData['@id'];

        $client->request('POST', '/api/sports.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Sport 2',
            'sportType' => $sportTypeIri
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportData);
        $sportIri = $sportData['@id'];
        $id = basename($sportIri);

        $client->request('GET', "/api/sports/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateSport(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_FOR_SPORT_3',
            'label' => 'Sport type pour Sport 3'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportTypeData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportTypeData);
        $sportTypeIri = $sportTypeData['@id'];

        $client->request('POST', '/api/sports.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Sport 3',
            'sportType' => $sportTypeIri
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportData);
        $sportIri = $sportData['@id'];
        $id = basename($sportIri);

        $client->request('PATCH', "/api/sports/$id.jsonld", [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Sport 3 mis à jour'
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Sport 3 mis à jour', $updated['name']);
    }

    public function testDeleteSport(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'code' => 'SPORT_TYPE_FOR_SPORT_4',
            'label' => 'Sport type pour Sport 4'
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportTypeData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportTypeData);
        $sportTypeIri = $sportTypeData['@id'];

        $client->request('POST', '/api/sports.jsonld', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json'
        ], json_encode([
            'name' => 'Sport 4',
            'sportType' => $sportTypeIri
        ]));

        $this->assertResponseStatusCodeSame(201);
        $sportData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('@id', $sportData);
        $sportIri = $sportData['@id'];
        $id = basename($sportIri);

        $client->request('DELETE', "/api/sports/$id.jsonld", [], [], [
            'HTTP_ACCEPT' => 'application/ld+json'
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}