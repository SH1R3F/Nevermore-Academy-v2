<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name'          => [
                'required',
                'string',
                'max:255',
                Rule::when(request()->isMethod('POST'), Rule::unique('roles'), Rule::unique('roles')->ignore($this->role))
            ],
            'description'   => ['nullable', 'string', 'max:255'],
            'permissions'   => ['present', 'array'],
            'permissions.*' => ['exists:permissions,slug']
        ];
    }

    protected function prepareForValidation()
    {
        /**
         *  Because it comes from frontend like this
         * "permissions" => array:2 [▼
         *      "update-role" => "on"
         *      "delete-role" => "on"
         *  ]
         */
        $this->merge([
            'permissions' => $this->permissions ? array_keys($this->permissions) : []
        ]);
    }
}
