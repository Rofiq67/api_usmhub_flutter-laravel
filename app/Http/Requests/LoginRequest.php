<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // public function rules()
    // {
    //     // Jika endpoint adalah login user (mobile)
    //     if ($this->is('api/login')) {
    //         return [
    //             'username' => 'required|string|min:10', // Contoh aturan validasi untuk username
    //             'password' => 'required|min:6', // Contoh aturan validasi untuk password
    //         ];
    //     }
    //     // Jika endpoint adalah login admin
    //     elseif ($this->is('api/login-admin')) {
    //         return [
    //             'email' => 'required|string|email', // Aturan validasi untuk email admin
    //             'password' => 'required|min:6', // Aturan validasi untuk password admin
    //         ];
    //     }
    // }
    public function rules()
    {
        return [
            'username' => 'required|string|min:6', // Sesuaikan dengan aturan validasi yang digunakan di loginApi()
            'password' => 'required|min:6', // Sesuaikan dengan aturan validasi yang digunakan di loginApi()
        ];
    }
}
