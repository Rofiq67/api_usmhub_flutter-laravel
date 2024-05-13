<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedRequest extends FormRequest
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
            'kategori' => 'required|in:Aspirasi,Pengaduan,Informasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    /**
     * Pesan kesalahan kustom untuk aturan validasi.
     */
    public function messages(): array
    {
        return [
            'kategori.required' => 'Kategori diperlukan.',
            'kategori.in' => 'Kategori tidak valid.',
            'judul.required' => 'Judul diperlukan.',
            'judul.max' => 'Judul terlalu panjang.',
            'deskripsi.required' => 'Deskripsi diperlukan.',
            'file_path.mimes' => 'File harus berupa gambar atau PDF.',
            'file_path.max' => 'File terlalu besar (maksimum 2MB).',
        ];
    }
}
