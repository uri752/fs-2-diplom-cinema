<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',           
            'duration' => 'required'            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ' Поле "Название фильма" должно быть заполнено!',
            'duration.required' => ' Поле "Продолжительность" должно быть заполнено!'            
        ];
    }

}
