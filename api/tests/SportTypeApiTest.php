<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportTypeApiTest extends WebTestCase
{
    
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllSportTypes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/sport_types');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSportTypes(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/sport_types', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Type 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetSportTypeById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Type 2',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('GET', "/api/sport_types/$id");

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateSportType(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Type 3',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/sport_types/$id", [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Type 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Sport Type 3 mis a jour', $updated['name']);
    }

    public function testDeleteSportType(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sport_types', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Type 4',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/sport_types/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
