<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDichVuRequest extends FormRequest
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
            'ten_dich_vu' => 'required|string|max:255',
            'gia_tien' => 'required|numeric|min:0',
            'hinh_anh' => 'required|string|max:255',
            'tinh_trang' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_dich_vu.required' => 'Vui lòng nhập tên dịch vụ.',
            'ten_dich_vu.string' => 'Tên dịch vụ phải là chuỗi ký tự.',
            'ten_dich_vu.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'gia_tien.required' => 'Vui lòng nhập giá dịch vụ.',
            'gia_tien.numeric' => 'Giá dịch vụ phải là số.',
            'gia_tien.min' => 'Giá dịch vụ không được nhỏ hơn 0.',
            'hinh_anh.required' => 'Vui lòng nhập hình ảnh.',
            'hinh_anh.string' => 'Hình ảnh phải là chuỗi ký tự.',
            'hinh_anh.max' => 'Hình ảnh không được vượt quá 255 ký tự.',
            'tinh_trang.required' => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean' => 'Tình trạng phải là true hoặc false.',
        ];
    }
}
