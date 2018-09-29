<?php

namespace App\Services\Analysis\Search;

use GuzzleHttp\Client;

/**
 * Class FilmService
 * @package App\Services\Analysis\Search
 */
class FilmService
{
    /**
     * @var string
     */
    private $url = "https://api.themoviedb.org/3/search/movie";

    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $apiKey;

    /**
     * FilmService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('MOVIE_DB_KEY');
    }

    /**
     * @param string $name
     * @return string
     */
    public function getUrl(string $name): string
    {
        $params = [
            'api_key' => $this->apiKey,
            'query' => $name
        ];
        return $this->url . '?' . urldecode(http_build_query($params));
    }

    /**
     * @param string $title
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $title): ?array
    {
        $data = $this->client->request('GET', $this->getUrl($title))->getBody();
        $data = json_decode($data, true);
        if ($data && $film = $data['results'][0]) {
            if ($film['title'] === $title) {
                return $this->serializeFilm($film);
            }
        }
        return null;
    }

    /**
     * @param array $film
     * @return array
     */
    private function serializeFilm(array $film): array
    {
        return [
            'title' => $film['title'],
            'vote_average' => $film['vote_average'],
            'poster' => $film['poster_path'],
            'description' => $film['overview'],
            'release_date' => $film['release_date'],
            'video' => $film['video']
        ];
    }
}
