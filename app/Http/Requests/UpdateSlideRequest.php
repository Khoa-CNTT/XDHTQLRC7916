<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlideRequest extends FormRequest
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
            'link_hinh_anh' => 'required|string',
            'tinh_trang' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'link_hinh_anh.required' => 'Vui lòng nhập link hình ảnh.',
            'link_hinh_anh.string' => 'Link hình ảnh phải là chuỗi ký tự.',
            'tinh_trang.required' => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean' => 'Tình trạng phải là true hoặc false.',
        ];
    }
}
