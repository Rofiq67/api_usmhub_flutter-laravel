<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'username' => 'required|string|min:10|unique:users',
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'progdi' => 'required|in:Teknik Informatika,Sistem Informasi,Ilmu Komunikasi,Pariwisata',
            'tgl_lahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ];
    }
}
