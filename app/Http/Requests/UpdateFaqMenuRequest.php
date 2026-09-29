<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqMenuRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'menu' => ['required', 'string', 'max:50'],
            'sub_menu' => ['required', 'string', 'max:255'],
            'aktif' => ['required', 'in:Y,T'],
            'no_urut' => ['required', 'integer', 'min:1']
        ];
    }
}
