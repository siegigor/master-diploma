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
    protected $url = "https://api.themoviedb.org/3/search/tv";

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
        if ($data && $tv = ($data['results'][0] ?? null)) {
            if ($tv['name'] === $title) {
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
            'title' => $tv['name'],
            'vote_average' => $tv['vote_average'],
            'poster' => $tv['poster_path'],
            'description' => $tv['overview'],
            'release_date' => $tv['first_air_date'],
            'video' => $tv['video'] ?? ''
        ]);
        $result->setFilmStatus();
        if (!$result->save()) {
            return null;
        }
        return $result;
    }
}
