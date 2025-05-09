<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemBanerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
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
