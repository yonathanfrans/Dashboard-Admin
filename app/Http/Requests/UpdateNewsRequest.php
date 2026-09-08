<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'heading' => ['required', 'string', 'max:255'],
            'flag_kegiatan' => ['required', 'in:Y,T'],
            'thumbnail_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'large_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:5120'],
            'content' => ['required', 'string'],            
            'source' => ['required', 'string', 'max:200'],
            'publish' => ['required', 'in:Y,T']
        ];
    }
}
