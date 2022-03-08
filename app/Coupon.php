<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code'     => 'required|unique:coupons',
        'title'    => 'required',
        'discount' => 'required',
        'limit'    => 'required'
    ];

    public $table = 'coupons';
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'       => 'integer',
        'code'     => 'string',
        'title'    => 'string',
        'discount' => 'float',
        'limit'    => 'integer'
    ];

}
