<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
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
        $rules =[];

        foreach
         (config('translatable.locales') as $locale) {
        
            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')]];

        }

        return $rules;
        
    }
}
