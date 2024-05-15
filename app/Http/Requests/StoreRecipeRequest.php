<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'description' => 'required|string|min:3|max:1000',
            'category_id' => 'required',
            'dietary_id' => 'required',
            'comment' => 'nullable|string|max:1000',
            'preparationTime' => 'required|integer|min:1',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredientName' => 'required|string|max:255|min:3',
            'ingredients.*.measurementUnit' => 'required|string|max:50|min:3',
            'preparationSteps' => 'required|array|min:1',
            'preparationSteps.*' => 'required|string|min:3',
            'image_id' => 'required',
        ];
    }
}
