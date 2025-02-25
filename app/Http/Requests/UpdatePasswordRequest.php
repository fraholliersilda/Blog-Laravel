<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => 'nullable|min:8|confirmed',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
