<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatBanerRequest extends FormRequest
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
            'ten_baner' => 'required',
            'hinh_anh' => 'required',
            'link' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_baner.required' => 'Vui lòng nhập tên slide.',
            'hinh_anh.required' => 'Vui lòng nhập hình ảnh.',
            'link.required' => 'Vui lòng nhập link.',
        ];
    }
}
