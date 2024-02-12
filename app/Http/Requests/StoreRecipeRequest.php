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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,name',
            'comment' => 'sometimes|string|max:1000',
            'preparationTime' => 'required|integer|min:1',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredientName' => 'required|string|max:255',
            'ingredients.*.measurementUnit' => 'required|string|max:50',
            'preparationSteps' => 'required|array|min:1',
            'preparationSteps.*' => 'required|string',
        ];
    }
}
