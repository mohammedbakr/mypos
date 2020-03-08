<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $rules =[
            'category_id' => ['required'],
        ];

        foreach
         (config('translatable.locales') as $locale) {
        
            $rules += [$locale . '.name' => ['required', Rule::unique('product_translations', 'name')
                ->ignore($this->product->id, 'product_id')]];
            $rules += [$locale . '.description' => ['required']];

        }

        $rules +=[
            'image' => ['image'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric']
        ];

        return $rules;
    }
}
