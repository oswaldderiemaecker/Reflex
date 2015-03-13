<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 12/03/15
 * Time: 20:03
 */

namespace Reflex\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'required',
          //  'region_id' => 'required',
            'business_unit_id' => 'required',
            'code' => 'required|max:20',
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