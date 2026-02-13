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
        $client->request('GET', '/api/championships');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateChampionship(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 1',
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetChampionshipById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 2',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('GET', "/api/championships/$id");

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateChampionship(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 3',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/championships/$id", [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Championnat 3 mis a jour', $updated['name']);
    }

    public function testDeleteChampionship(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 4',
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/championships/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
