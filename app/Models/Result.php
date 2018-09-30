<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Result
 * @package App\Models
 */
class Result extends Model
{
    /**
     * @var string
     */
    const FILM = 'Film';

    /**
     * @var string
     */
    const TV = 'Television show';

    /**
     * @var string
     */
    const NOT_FOUND = 'Not found';

    /**
     * @var string
     */
    protected $table = 'result';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return void
     */
    public function setFilmStatus()
    {
        $this->status = self::FILM;
    }

    /**
     * @return void
     */
    public function setTvStatus()
    {
        $this->status = self::TV;
    }

    /**
     * @return void
     */
    public function setNotFoundStatus()
    {
        $this->status = self::NOT_FOUND;
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isTypeFilm(string $type): bool
    {
        return $type === self::FILM;
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isTypeTv(string $type): bool
    {
        return $type === self::TV;
    }

    /**
     * @return bool
     */
    public function isFilm(): bool
    {
        return $this->status === self::FILM;
    }

    /**
     * @return bool
     */
    public function isTv(): bool
    {
        return  $this->status === self::TV;
    }

    /**
     * @return bool
     */
    public function isNotFound(): bool
    {
        return  $this->status === self::NOT_FOUND;
    }

    /**
     * @return string
     */
    public function getPosterPathAttribute(): string
    {
        return 'https://image.tmdb.org/t/p/original' . $this->poster;
    }
}
