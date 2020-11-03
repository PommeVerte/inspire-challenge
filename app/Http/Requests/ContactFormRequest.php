<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContactFormRequest
 *
 * Providing extra logic for contact form submissions in the event we need to expand functionality.
 *
 * @author  Dylan Millikin <dylan.millikin@gmail.com>
 * @package App\Http\Requests
 */
class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // authorize for all
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|max:128',
            'email'     => 'required|email:rfc,dns|max:128',
            'phone'     => 'nullable|phone:AUTO,US|max:100', // error message in lang/xx/validation.php
            'message'   => 'required',
        ];
    }
}
