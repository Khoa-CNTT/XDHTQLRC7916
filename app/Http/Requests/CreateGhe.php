<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGhe extends FormRequest
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
            'ten_ghe'     => 'required|string|max:50',
            'phong_id'    => 'required|exists:phongs,id',
            'hang'        => 'required|string|max:5',
            'cot'         => 'required|integer|min:1',
            'loai_ghe'    => 'required|string|max:30',
            'trang_thai'  => 'required|boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'ten_ghe.required'    => 'Tên ghế không được để trống.',
            'ten_ghe.string'      => 'Tên ghế phải là chuỗi.',
            'ten_ghe.max'         => 'Tên ghế không được vượt quá 50 ký tự.',

            'phong_id.required'  => 'Vui lòng chọn phòng.',
            'phong_id.exists'    => 'Phòng không tồn tại.',

            'hang.required'      => 'Hàng ghế không được để trống.',
            'hang.string'        => 'Hàng ghế phải là chuỗi.',
            'hang.max'           => 'Hàng ghế không được vượt quá 5 ký tự.',

            'cot.required'       => 'Cột ghế không được để trống.',
            'cot.integer'        => 'Cột ghế phải là số nguyên.',
            'cot.min'            => 'Cột ghế phải lớn hơn hoặc bằng 1.',

            'loai_ghe.required'  => 'Loại ghế không được để trống.',
            'loai_ghe.string'    => 'Loại ghế phải là chuỗi.',
            'loai_ghe.max'       => 'Loại ghế không được vượt quá 30 ký tự.',

            'trang_thai.required'=> 'Vui lòng chọn trạng thái.',
            'trang_thai.boolean' => 'Trạng thái phải là true hoặc false.'
        ];
    }

}
