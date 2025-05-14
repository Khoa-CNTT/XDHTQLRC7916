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
            'link' => 'required',
            'tinh_trang' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'link.required' => 'Vui lòng nhập link.',
            'tinh_trang.required' => 'Vui lòng chọn trạng thái.',
        ];
    }
}
