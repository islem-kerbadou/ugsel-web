<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SportApiTest extends WebTestCase
{
    
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testGetAllSports(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/sports');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSports(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetSportById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport 2',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('GET', "/api/sports/$id");

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateSport(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport 3',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/sports/$id", [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Sport 3 mis a jour', $updated['name']);
    }

    public function testDeleteSport(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport 4',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/sports/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
