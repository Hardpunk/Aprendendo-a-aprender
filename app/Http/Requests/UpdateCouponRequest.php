<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Coupon;

class UpdateCouponRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Coupon::$rules;
        $rules['code'] = "required|unique:coupons,code,{$this->coupon},id";
        return $rules;
    }
}
