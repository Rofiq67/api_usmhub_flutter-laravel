<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AspirasiRequest extends FormRequest
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
    public function rules()
    {
        return [
            'jenis_aspirasi' => 'required|in:Fasilitas,Kebijakan,Pelayanan',
            'program_studi' => 'required|in:Teknik Informatika,Sistem Informasi,Ilmu Komunikasi,Pariwisata',
            'keterangan' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5', // Jika diperlukan
        ];
    }
}
