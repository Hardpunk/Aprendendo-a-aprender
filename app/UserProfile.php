<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $table = 'users_profiles';

    protected $guarded = [];

    /**
     * Return Carbon instance of birthday attribute
     *
     * @param  mixed  $value
     * @return Carbon
     */
    public function getBirthdayAttribute($value)
    {
        return new Carbon($value);
    }
}
