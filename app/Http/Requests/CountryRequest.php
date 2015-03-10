<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 9/03/15
 * Time: 18:06
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:10',
            'name' => 'required|max:100',
            'currency' => 'required|max:10',
            'language' => 'required|max:10'
           // 'description' => 'required'
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


}