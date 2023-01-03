<?php

namespace App\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RiotController {
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $API_KEY = $_ENV['RIOT_API_KEY'];

        $this->client = $client->withOptions(
            [
                'base_uri' => 'https://euw1.api.riotgames.com/lol',
                'headers' => [
                    'X-Riot-Token' => $API_KEY
                ]
            ]
        );
    }

    public function getSummonerByName($name)
    {
        $response = $this->client->request(
            'GET',
            '/summoner/v4/summoners/by-name/' . $name
        );

        return $response->toArray();
    }

    public function getCurrentGameInfoBySummonerId($id)
    {
        $response = $this->client->request(
            'GET',
            '/spectator/v4/active-games/by-summoner/' . $id
        );

        return $response->toArray();
    }

    public function getMostRecentMatchIdByAccountId($id)
    {
        $response = $this->client->request(
            'GET',
            '/match/v5/matches/by-puuid/' . $id . '/ids?start=0&count=1'
        );

        $matches = $response->toArray();

        return $matches['matches'][0]['gameId'];
    }

    public function getMatchInfoByMatchId($id)
    {
        $response = $this->client->request(
            'GET',
            '/match/v5/matches/' . $id
        );

        return $response->toArray();
    }
}