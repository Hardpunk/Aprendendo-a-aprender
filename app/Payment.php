<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'g-recaptcha-response' => 'recaptcha',
        'payment_method'       => 'required',
        'cc_number'            => 'required_if:payment_method,credit_card',
        'cc_holder'            => 'required_if:payment_method,credit_card',
        'cc_expiry_month'      => 'required_if:payment_method,credit_card|date_format:m',
        'cc_expiry_year'       => 'required_if:payment_method,credit_card|date_format:Y',
        'cc_cvv'               => 'required_if:payment_method,credit_card|numeric',
        'cc_installments'      => 'required_if:payment_method,credit_card|integer',
        'zipcode'              => 'required',
        'state'                => 'required',
        'city'                 => 'required',
        'street'               => 'required',
        'street_number'        => 'required',
        'neighborhood'         => 'required',
        'country'              => 'required',
    ];

    public $table = 'payments';
    protected $guarded = [];

    /**
     * Get payment status.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return get_payment_status($value);
    }

    /**
     * Get payment method.
     *
     * @param  string  $value
     * @return string
     */
    public function getPaymentMethodAttribute($value)
    {
        return get_payment_type($value);
    }

    /**
     * Return Trails
     *
     * @return BelongsToMany
     */
    public function Trails()
    {
        return $this->belongsToMany(Trail::class, 'payments_items')->withTimestamps();
    }

    /**
     * Return Courses
     *
     * @return BelongsToMany
     */
    public function Courses()
    {
        return $this->belongsToMany(Course::class, 'payments_items')->withTimestamps();
    }

    /**
     * Return User
     *
     * @return HasOne
     */
    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Return Coupon
     *
     * @return HasOne
     */
    public function Coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    public function items()
    {
        $trails = $this->trails->toArray();
        $courses = $this->courses->toArray();
        return array_merge($trails, $courses);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y H:i:s');
    }
}
