<?php

namespace App\Http\Requests\Telegram\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'service_category_id' => 'required|int|exists:service_categories,id',
            'description' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'complete_at' => 'required|date',
            'price' => 'required|int',
        ];
    }
}
