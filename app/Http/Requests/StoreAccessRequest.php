<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAccessRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:255'],
            'unit_kerja' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'jns_permintaan' => ['required', 'in:pendaftaran'],
            'jns_akses' => ['required', 'array', 'min:1'],
            'jns_akses.*' => ['in:database,aplikasi,sistem_operasi,lainnya'],
            'keterangan_aplikasi' => [Rule::requiredIf(in_array('aplikasi', $this->input('jns_akses', []))), 'nullable', 'string', 'max:255'],
            'keterangan_lainnya' => [Rule::requiredIf(in_array('lainnya', $this->input('jns_akses', []))), 'nullable', 'string', 'max:255'],
            'kebutuhan_permintaan' => ['required', 'string', 'max:255'],
            'sifat_akses' => ['required', 'in:rutin,sementara,selalu_aktif'],
            'waktu_akses' => ['required', 'in:7x24_jam,jam_kerja,lainnya'],
            'keterangan_waktu_lainnya' => [Rule::requiredIf($this->waktu_akses === 'lainnya'), 'nullable', 'string', 'max:255'],
            'masa_berlaku' => ['required', 'date'],
            'setuju_ketentuan' => ['accepted'],
            'url_form_akses' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'url_api' => ['required', 'string', 'max:255'],
            'catatan_api' => ['nullable', 'string', 'max:255'],
            'url_panduan' => ['required', 'file', 'mimes:pdf', 'max:5120']
        ];
    }
}
