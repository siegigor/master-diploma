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
    protected $url = "https://api.themoviedb.org/3/search/movie";

    /**
     * @param string $title
     * @param string $image
     * @return Result|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $title, string $image): ?Result
    {
        $data = $this->client->request('GET', $this->getUrl($title))->getBody();
        $data = json_decode($data, true);
        if ($data && $film = $data['results'][0]) {
            if ($film['title'] === $title) {
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
            'title' => $film['title'],
            'vote_average' => $film['vote_average'],
            'poster' => $film['poster_path'],
            'description' => $film['overview'],
            'release_date' => $film['release_date'],
            'video' => $film['video']
        ]);
        $result->setFilmStatus();
        if (!$result->save()) {
            return null;
        }
        return $result;
    }
}
