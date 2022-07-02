<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->id() != $this->route('id')) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:11',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|string|min:6',
            'bank_account_number' => 'required|digits:16'
        ];
    }
}
