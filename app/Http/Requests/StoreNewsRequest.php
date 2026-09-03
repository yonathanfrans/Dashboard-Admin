<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'news_category_id' => ['required', 'exists:news_categories,id'],
            'title' => ['required'],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'content' => ['required'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable','file', 'mimes:png,jpg,jpeg,pdf', 'max:5120'],
            'sumber' => ['required'],
            'status' => ['required', 'in:Published,Unpublished'],
            'tgl_publish' => ['nullable', 'date']
        ];
    }
}
