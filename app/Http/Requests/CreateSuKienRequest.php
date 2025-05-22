<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSuKienRequest extends FormRequest
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
            'ten_su_kien' => 'required|string|max:255',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date',
            'hinh_anh' => 'required|string|max:255',
            'mo_ta' => 'required|string',
            'tinh_trang' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_su_kien.required' => 'Vui lòng nhập tên sự kiện.',
            'ten_su_kien.string' => 'Tên sự kiện phải là chuỗi.',
            'ten_su_kien.max' => 'Tên sự kiện không được vượt quá 255 ký tự.',
            'ngay_bat_dau.required' => 'Vui lòng nhập ngày bắt đầu.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu phải là ngày.',
            'ngay_ket_thuc.required' => 'Vui lòng nhập ngày kết thúc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc phải là ngày.',
            'hinh_anh.required' => 'Vui lòng nhập hình ảnh.',
            'hinh_anh.string' => 'Hình ảnh phải là chuỗi.',
            'hinh_anh.max' => 'Hình ảnh không được vượt quá 255 ký tự.',
            'mo_ta.required' => 'Vui lòng nhập mô tả.',
            'mo_ta.string' => 'Mô tả phải là chuỗi.',
            'tinh_trang.required' => 'Vui lòng chọn trạng thái.',
            'tinh_trang.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
