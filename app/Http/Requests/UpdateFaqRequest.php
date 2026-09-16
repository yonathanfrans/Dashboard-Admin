<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFaqRequest extends FormRequest
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
            'id_sub' => ['required', 'exists:faq_menu,id_sub'],
            'jenis' => ['required', 'in:Menu,pdf'],
            'pertanyaan' => ['required', 'string'],
            'jawaban' => [
                Rule::requiredIf($this->jenis === 'Menu'),
                'nullable', 
                'string',
            ],
            'link' => [
                Rule::requiredIf(
                    fn () => $this->jenis === 'pdf' && !$this->route('faq')?->link
                ),
                'nullable', 
                'file', 
                'mimes:pdf', 
                'max:5120'
            ],
            'publish' => ['required', 'in:Y,T']
        ];
    }
}
