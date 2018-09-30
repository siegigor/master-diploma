<?php

namespace App\Services\Analysis\Search;

use App\Models\Result;
use GuzzleHttp\Client;

/**
 * Class SearchService
 * @package App\Services\Analysis\Search
 */
abstract class SearchService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    const NA = "N/A";

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
            'apikey' => $this->apiKey,
            't' => $name
        ];
        return $this->url . '&' . urldecode(http_build_query($params));
    }

    /**
     * @param string $image
     * @return Result|null
     */
    public function createNotFound(string $image): ?Result
    {
        /** @var Result $result */
        $result = Result::make([
            'image' => $image
        ]);
        $result->setNotFoundStatus();
        if (!$result->save()) {
            return null;
        }
        return $result;
    }

    /**
     * @param string $title
     * @param string $image
     * @return Result|null
     */
    abstract public function find(string $title, string $image): ?Result;
}
