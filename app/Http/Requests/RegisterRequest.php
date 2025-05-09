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
    public function rules(): array
    {
        return [
            //
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|string|min:8',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender'=>'required|in:male,female'
        ];
    }
}
