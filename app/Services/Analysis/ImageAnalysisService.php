<?php

namespace App\Services\Analysis;

use App\Services\Analysis\Search\FilmService;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Protobuf\Internal\RepeatedField;

/**
 * Class ImageAnalysisService
 * @package App\Services\Analysis
 */
class ImageAnalysisService
{
    /**
     * string
     */
    private $imageResource;

    /**
     * @var FilmService
     */
    private $filmService;

    /**
     * ImageAnalysisService constructor.
     * @param FilmService $filmService
     */
    public function __construct(FilmService $filmService)
    {
        $this->filmService = $filmService;
    }

    /**
     * @param string $path
     * @return void
     */
    public function setImageFullPath(string $path): void
    {
        $this->imageResource = fopen('/var/www/public/' . $path, 'r');
    }

    /**
     * @throws \Google\ApiCore\ApiException
     * @throws \Google\ApiCore\ValidationException
     */
    public function analyzeImage($path)
    {
        $this->setImageFullPath($path);

        $imageAnnotator = new ImageAnnotatorClient();
        $image = $this->imageResource;
        $response = $imageAnnotator->webDetection($image);
        $web = $response->getWebDetection();

        return $this->identifyEntity($web->getWebEntities());
    }

    /**
     * @param $entities
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function identifyEntity($entities)
    {
        $type = null;
        $index = null;
        foreach ($entities as $key => $entity) {
            $description = $entity->getDescription();
            if ($this->isTypeFilm($description)) {
                $type = self::FILM;
                $index = $key;
                break;
            }
        }
        foreach ($entities as $key => $entity) {
            if ($key === $index) {
                break;
            }
            $film = $this->filmService->find($entity->getDescription());
        }
        return null;
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isTypeFilm(string $type): bool
    {
        return $type === self::FILM;
    }
}
