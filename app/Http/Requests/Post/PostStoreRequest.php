<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends FormRequest
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
            'title' => 'required|unique:posts,title',
            'content' => 'required',
            'category' => 'required|exists:categories,id',
            'feature_image' => 'required|mimes:png,jpg,jpeg|max:1024',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'tags' => 'nullable',
            'visibility' => [
                Rule::when(auth()->user()->type == 'superAdmin', [
                    'required',
                    'in:1,0'
                ])
            ]
        ];
    }
}
