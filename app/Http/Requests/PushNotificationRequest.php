<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PushNotificationRequest extends FormRequest
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
            'message' => ['required', 'max:255'],
            'recipients'   => ['present', 'array'],
            'recipients.*' => ['exists:roles,name'],
            'via'   => ['present', 'array'],
            'via.*' => ['in:database,sms,mail'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'recipients' => $this->recipients ? array_keys(array_filter($this->recipients)) : [],
            'via' => $this->via ? array_keys(array_filter($this->via)) : [],
        ]);
    }
}
