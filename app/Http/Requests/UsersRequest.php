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
            'progdi' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'alamat' => 'required|string|max:255',
            'img_profile' => 'nullable|image|max:2048', // max 2MB
        ];
    }
}
