<?php

namespace App\Models;

use App\Payment;
use App\UserProfile;
use DateTimeInterface;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'              => 'required|string',
        'email'             => 'required|email|string',
        'email_verified_at' => 'nullable',
        'password'          => 'required|string',
    ];

    public $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'name'  => 'string',
        'email' => 'string',
    ];

    /**
     * @return HasMany
     **/
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /**
     * User Profile
     *
     * @return HasOne
     */
    public function Profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y H:i:s');
    }
}
