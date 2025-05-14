<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGocDienAnhRequest extends FormRequest
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
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'required|string|max:255',
            'mo_ta' => 'required|string|max:255',
            'tinh_trang' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'tieu_de.required' => 'Vui lòng nhập tên góc diễn án.',
            'tieu_de.string' => 'Tên góc diễn án phải là chuỗi.',
            'tieu_de.max' => 'Tên góc diễn án không được vượt quá 255 ký tự.',
            'hinh_anh.required' => 'Vui lòng nhập hình ảnh.',
            'hinh_anh.string' => 'Hình ảnh phải là chuỗi.',
            'hinh_anh.max' => 'Hình ảnh không được vượt quá 255 ký tự.',
            'mo_ta.required' => 'Vui lòng nhập mô tả.',
            'mo_ta.string' => 'Mô tả phải là chuỗi.',
            'mo_ta.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'tinh_trang.required' => 'Vui lòng chọn trạng thái.',
            'tinh_trang.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}