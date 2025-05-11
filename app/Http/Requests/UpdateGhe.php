<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGhe extends FormRequest
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
            'ten_ghe'    => 'required|string|max:50',
            'phong_id'   => 'required|exists:phongs,id',
            'hang'       => 'required|string|max:5',
            'cot'        => 'required|integer|min:1',
            'loai_ghe'   => 'required|string|in:thuong,doi,vip', // chỉnh theo danh sách loại ghế thực tế
            'trang_thai'=> 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_ghe.required'     => 'Vui lòng nhập tên ghế.',
            'ten_ghe.string'       => 'Tên ghế phải là chuỗi ký tự.',
            'ten_ghe.max'          => 'Tên ghế không được vượt quá 50 ký tự.',

            'phong_id.required'    => 'Vui lòng chọn phòng.',
            'phong_id.exists'      => 'Phòng không tồn tại.',

            'hang.required'        => 'Vui lòng nhập hàng ghế.',
            'hang.string'          => 'Hàng ghế phải là chuỗi.',
            'hang.max'             => 'Hàng ghế không được vượt quá 5 ký tự.',

            'cot.required'         => 'Vui lòng nhập cột.',
            'cot.integer'          => 'Cột phải là số nguyên.',
            'cot.min'              => 'Giá trị cột phải lớn hơn hoặc bằng 1.',

            'loai_ghe.required'    => 'Vui lòng chọn loại ghế.',
            'loai_ghe.in'          => 'Loại ghế không hợp lệ.',

            'trang_thai.required'  => 'Vui lòng chọn trạng thái.',
            'trang_thai.boolean'   => 'Trạng thái phải là true hoặc false.',
        ];
    }

}
