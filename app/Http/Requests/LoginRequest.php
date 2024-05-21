<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:6', // Sesuaikan dengan aturan validasi yang digunakan di loginApi()
            'password' => 'required|min:6', // Sesuaikan dengan aturan validasi yang digunakan di loginApi()
        ];
    }
}
