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
            'noi_dung' => 'required|string|min:5',
            'ngay_dang' => 'required|date',
            'trang_thai' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'tieu_de.required' => 'Vui lòng nhập tên góc điện ảnh.',
            'tieu_de.string' => 'Tên góc điện ảnh phải là chuỗi.',
            'tieu_de.max' => 'Tên góc điện ảnh không được vượt quá 255 ký tự.',
            'hinh_anh.required' => 'Vui lòng nhập hình ảnh.',
            'hinh_anh.string' => 'Hình ảnh phải là chuỗi.',
            'hinh_anh.max' => 'Hình ảnh không được vượt quá 255 ký tự.',
            'noi_dung.required' => 'Vui lòng nhập nội dung.',
            'noi_dung.string' => 'Nội dung phải là chuỗi.',
            'noi_dung.min' => 'Phải có ít nhất 5 ký tự.',
            'ngay_dang.required' => 'Vui lòng chọn ngày đăng.',
            'ngay_dang.date' => 'Ngày đăng phải là ngày.',
            'trang_thai.required' => 'Vui lòng chọn trạng thái.',
            'trang_thai.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
