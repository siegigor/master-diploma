<?php

namespace App\Services\Analysis\Search;

use App\Models\Result;

/**
 * Class TvService
 * @package App\Services\Analysis\Search
 */
class TvService extends SearchService
{
    /**
     * @var string
     */
    protected $url = "http://www.omdbapi.com?type=series";

    /**
     * @param string $title
     * @param string $image
     * @return Result|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $title, string $image): ?Result
    {
        $data = $this->client->request('GET', $this->getUrl($title))->getBody();
        $tv = json_decode($data, true);
        if ($tv && isset($tv['Title'])) {
            if ($tv['Title'] === $title) {
                return $this->serializeTv($tv, $image);
            }
        }
        return null;
    }

    /**
     * @param array $tv
     * @param string $image
     * @return Result|null
     */
    private function serializeTv(array $tv, string $image): ?Result
    {
        /** @var Result $result */
        $result = Result::make([
            'image' => $image,
            'title' => $tv['Title'],
            'vote_average' => $tv['imdbRating'],
            'poster' => $tv['Poster'],
            'description' => $tv['Plot'],
            'release_date' => $tv['Released'],
            'rated' => $tv['Rated'],
            'runtime' => $tv['Runtime'],
            'genre' => $tv['Genre'],
            'director' => $tv['Director'],
            'writer' => $tv['Writer'],
            'actors' => $tv['Actors'],
            'language' => $tv['Language'],
            'country' => $tv['Country'],
            'awards' => $tv['Awards'],
        ]);
        $result->setTvStatus();
        if (!$result->save()) {
            return null;
        }
        return $result;
    }
}
