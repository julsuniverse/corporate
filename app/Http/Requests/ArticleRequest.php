<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('save', 'App\Article');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validator = parent::getValidatorInstance();
        $validator->sometimes('alias', 'unique:articles|max:255', function ($input) {
            return !empty($input->alias);
        });

        return [
            'title' => 'required|max:255',
            'text' => 'required',
            'category_id' => 'required|integer',
        ];
    }
}
