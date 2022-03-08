<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'              => 'required',
        'email'             => ['required', 'email'],
        'email_verified_at' => 'nullable',
        'password'          => 'required',
    ];
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
     * @return HasMany
     **/
    public function Payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}
