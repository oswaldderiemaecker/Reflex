<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 9/03/15
 * Time: 18:06
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class BusinessUnitRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:20',
            'company_id' => 'required',
            'name' => 'required|max:100',

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