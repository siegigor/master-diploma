<?php

namespace App\Services\Analysis;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Protobuf\Internal\RepeatedField;

/**
 * Class ImageAnalysisService
 * @package App\Services\Analysis
 */
class ImageAnalysisService
{
    /**
     * @var string
     */
    const FILM = 'Film';

    /**
     * @var string
     */
    const TV = 'Television';

    /**
     * string
     */
    private $imageResource;

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
     * @param RepeatedField $entities
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
            return $entity->getDescription();
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
