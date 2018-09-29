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
    protected $table = 'result';

    /**
     * @var array
     */
    protected $guarded = ['*'];
}
