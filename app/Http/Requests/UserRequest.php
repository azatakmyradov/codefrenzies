<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user') ? $this->route('user') : new User();

        return [
            'name' => ['required', 'max:25'],
            'email' => ['required', 'max:30', 'email', Rule::unique('users', 'email')->ignore($user)],
            'password' => $user->exists ? ['nullable'] : ['required']
        ];
    }
}
