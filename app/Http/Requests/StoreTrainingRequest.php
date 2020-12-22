<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
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
        return [
            'title' => 'required|min:3',
            'description' => 'required',
            'attachment' => 'mimes:pdf'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Sila isi tajuk betul-betul',
            'description.required' => 'Sila isi kandungan',
            'title.min' => 'Kurang-kurang :min huruf bos'
        ];
    }
}
