<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDanhGia extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_phim'        => 'required|integer|exists:phims,id',
            'id_khach_hang'  => 'required|integer|exists:khach_hangs,id',
            'noi_dung'       => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'id_phim.required'        => 'Vui lòng chọn phim.',
            'id_phim.integer'         => 'ID phim phải là số.',
            'id_phim.exists'          => 'Phim không tồn tại.',

            'id_khach_hang.required'  => 'Vui lòng chọn khách hàng.',
            'id_khach_hang.integer'   => 'ID khách hàng phải là số.',
            'id_khach_hang.exists'    => 'Khách hàng không tồn tại.',

            'noi_dung.required'       => 'Vui lòng nhập nội dung đánh giá.',
            'noi_dung.string'         => 'Nội dung phải là chuỗi.',
            'noi_dung.max'            => 'Nội dung không được vượt quá 500 ký tự.',
        ];
    }
}
