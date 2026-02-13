<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChampionshipApiTest extends WebTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    private function createCompetition($client): string
    {
        // First create a Sport
        $client->request('POST', '/api/sports', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Sport Test',
        ]));
        $this->assertResponseStatusCodeSame(201);
        $sportData = json_decode($client->getResponse()->getContent(), true);
        $sportIri = $sportData['@id'] ?? '/api/sports/' . $sportData['id'];

        // Then create a Competition with the Sport
        $client->request('POST', '/api/competitions', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Competition Test',
            'sport' => $sportIri,
        ]));
        $this->assertResponseStatusCodeSame(201);
        $competitionData = json_decode($client->getResponse()->getContent(), true);
        return $competitionData['@id'] ?? '/api/competitions/' . $competitionData['id'];
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
        $competitionIri = $this->createCompetition($client);

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 1',
            'competition' => $competitionIri,
        ]));

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetChampionshipById(): void
    {
        $client = static::createClient();
        $competitionIri = $this->createCompetition($client);

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 2',
            'competition' => $competitionIri,
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
        $competitionIri = $this->createCompetition($client);

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 3',
            'competition' => $competitionIri,
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('PATCH', "/api/championships/$id", [], [], ['CONTENT_TYPE' => 'application/merge-patch+json'], json_encode([
            'name' => 'Championnat 3 mis a jour',
        ]));

        $this->assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Championnat 3 mis a jour', $updated['name']);
    }

    public function testDeleteChampionship(): void
    {
        $client = static::createClient();
        $competitionIri = $this->createCompetition($client);

        $client->request('POST', '/api/championships', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode([
            'name' => 'Championnat 4',
            'competition' => $competitionIri,
        ]));

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];

        $client->request('DELETE', "/api/championships/$id");

        $this->assertResponseStatusCodeSame(204);
    }
}
