<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'jenis_pengaduan' => 'required|in:Fasilitas,Kebijakan,Pelayanan',
            'program_studi' => 'required|in:Teknik Informatika,Sistem Informasi,Ilmu Komunikasi,Pariwisata',
            'keterangan' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5', // Jika diperlukan
            'bukti_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Maksimum 2MB
        ];
    }
}
