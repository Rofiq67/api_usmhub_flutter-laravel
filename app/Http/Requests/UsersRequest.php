<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->user()->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'img_profile' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'tgl_lahir' => 'nullable|date',
            'progdi' => 'nullable|string|in:Teknik Informatika,Sistem Informasi,Ilmu Komunikasi,Pariwisata',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
        ];
    }
}
