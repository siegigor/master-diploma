<?php

namespace App\Services\Analysis\Search;

use App\Models\Result;

/**
 * Class FilmService
 * @package App\Services\Analysis\Search
 */
class FilmService extends SearchService
{
    /**
     * @var string
     */
    protected $url = "http://www.omdbapi.com?type=movie";

    /**
     * @param string $title
     * @param string $image
     * @return Result|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $title, string $image): ?Result
    {
        $data = $this->client->request('GET', $this->getUrl($title))->getBody();
        $film = json_decode($data, true);
        if ($film && isset($film['Title']) && $film['imdbRating'] !== self::NA) {
            if ($film['Title'] === $title) {
                return $this->serializeFilm($film, $image);
            }
        }
        return null;
    }

    /**
     * @param array $film
     * @param string $image
     * @return Result|null
     */
    private function serializeFilm(array $film, string $image): ?Result
    {
        /** @var Result $result */
        $result = Result::make([
            'image' => $image,
            'title' => $film['Title'],
            'vote_average' => $film['imdbRating'],
            'poster' => $film['Poster'],
            'description' => $film['Plot'],
            'release_date' => $film['Released'],
            'rated' => $film['Rated'],
            'runtime' => $film['Runtime'],
            'genre' => $film['Genre'],
            'director' => $film['Director'],
            'writer' => $film['Writer'],
            'actors' => $film['Actors'],
            'language' => $film['Language'],
            'country' => $film['Country'],
            'awards' => $film['Awards'],
        ]);
        $result->setFilmStatus();
        if (!$result->save()) {
            return null;
        }
        return $result;
    }
}
