<?php

namespace App\Services\Analysis;

use App\Models\Result;
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
     * @var string
     */
    private $path;

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
        $this->path = $path;
        $this->imageResource = fopen('/var/www/public/' . $this->path, 'r');
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
     * @param RepeatedField $entities
     * @return Result|array|null|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function identifyEntity(RepeatedField $entities)
    {
        $type = null;
        $index = null;
        foreach ($entities as $key => $entity) {
            $description = $entity->getDescription();
            if ($this->isTypeFilm($description)) {
                $type = Result::FILM;
                $index = $key;
                break;
            } elseif ($this->isTypeTv($description)) {
                $type = Result::TV;
                $index = $key;
                break;
            }
        }
        return $this->getResult($entities, $type, $index);
    }

    /**
     * @param RepeatedField $entities
     * @param null|string $type
     * @param int|null $index
     * @return Result|array|null|object
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getResult(RepeatedField $entities, ?string $type, ?int $index)
    {
        if (!$type && !$index) {
            return $this->filmService->createNotFound($this->path);
        }
        $entity = null;
        foreach ($entities as $key => $entity) {
            if ($key === $index) {
                break;
            }
            if ($this->isTypeFilm($type)) {
                $entity = $this->filmService->find($entity->getDescription(), $this->path);
            } elseif ($this->isTypeTv($type)) {
                $entity = null;
            }
            if ($entity) {
                return $entity;
            }
        }
        return $this->filmService->createNotFound($this->path);
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isTypeFilm(string $type): bool
    {
        return Result::isTypeFilm($type);
    }

    /**
     * @param string $type
     * @return bool
     */
    private function isTypeTv(string $type): bool
    {
        return Result::isTypeTv($type);
    }
}
