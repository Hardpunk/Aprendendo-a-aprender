<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Banner
 *
 * @property string $title
 * @property string $description
 * @property integer $order
 * @property string $image
 */
class Banner extends Model
{
    use HasFactory;

    public $table = 'banners';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'title',
        'description',
        'order',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'title'       => 'string',
        'description' => 'string',
        'order'       => 'integer',
        'image'       => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'title'       => 'required',
        'order'       => 'required|integer',
    ];
}
