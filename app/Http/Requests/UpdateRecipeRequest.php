<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|required|exists:categories,name',
            'preparationTime' => 'sometimes|required|integer|min:1',
            'ingredients' => 'sometimes|required|array|min:1',
            'ingredients.*.ingredientName' => 'sometimes|required|string|max:255',
            'ingredients.*.measurementUnit' => 'sometimes|required|string|max:50',
            'preparationSteps' => 'sometimes|required|array|min:1',
            'preparationSteps.*' => 'sometimes|required|string',
        ];
    }
}
