<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Banner;

class CreateBannerRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = Banner::$rules;
        $rules['image'] = 'required|image|mimes:jpg,jpeg,bmp,png|max:10240';
        return $rules;
    }
}
