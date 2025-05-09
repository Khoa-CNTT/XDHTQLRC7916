<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTheLoai extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ten_the_loai' => 'required|string|max:255',
            'mo_ta'        => 'required|string|max:500',
        ];
    }
    public function messages(): array
{
    return [
        'ten_the_loai.required' => 'Vui lòng nhập tên thể loại.',
        'ten_the_loai.string'   => 'Tên thể loại phải là một chuỗi ký tự.',
        'ten_the_loai.max'      => 'Tên thể loại không được vượt quá 255 ký tự.',

        'mo_ta.required'        => 'Vui lòng nhập mô tả.',
        'mo_ta.string'          => 'Mô tả phải là một chuỗi ký tự.',
        'mo_ta.max'             => 'Mô tả không được vượt quá 500 ký tự.'
    ];
}

}
