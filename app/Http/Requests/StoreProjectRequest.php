<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
                'type_id'=>'nullable',
                'title' => 'unique:projects|max:150',
                'content' => 'nullable',
                'cover_image' => 'nullable|max:520',
                'technologies'=>'exists:technologies.id'
            
        ];
    }
}
