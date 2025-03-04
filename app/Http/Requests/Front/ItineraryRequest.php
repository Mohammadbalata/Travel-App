<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ItineraryRequest extends FormRequest
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
            'name' => 'required|string|max:255',  
            'start_date' => 'required|date|before:end_date',  
            'end_date' => 'required|date|after:start_date',  
            'budget' => 'required|numeric|min:0', 
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
