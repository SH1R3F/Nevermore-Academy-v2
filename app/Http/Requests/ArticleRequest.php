<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'image' => [
                Rule::when(request()->isMethod('POST'), 'required', 'nullable'),
                File::types(['png', 'jpg', 'gif'])
            ],
            'title_en' => ['required', 'max:255'],
            'title_ar' => ['nullable', 'max:255'],
            'content_en' => ['required'],
            'content_ar' => ['nullable'],
        ];
    }
}
