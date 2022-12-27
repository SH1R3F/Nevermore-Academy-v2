<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::when(request()->isMethod('POST'), Rule::unique('users'), Rule::unique('users')->ignore($this->user)),
                'max:255'
            ],
            'mobile' => [
                'required',
                'numeric',
                Rule::when(request()->isMethod('POST'), Rule::unique('users'), Rule::unique('users')->ignore($this->user)),
            ],
            'password' => [
                Rule::when(request()->isMethod('POST'), 'required', 'nullable'),
                'string',
                'min:8',
                'max:255',
                'confirmed'
            ],
            'role' => ['required', 'exists:roles,id'],
            'image' => [
                Rule::when(request()->isMethod('POST'), 'required', 'nullable'),
                File::types(['png', 'jpg', 'gif'])->max(10 * 1024)
            ]
        ];
    }
}
