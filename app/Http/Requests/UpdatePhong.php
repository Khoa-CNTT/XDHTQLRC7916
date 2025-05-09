<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhong extends FormRequest
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
            'ten_phong'  => 'required|string|max:100',
            'id_phim'    => 'required|exists:phims,id',
            'tinh_trang'=> 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_phong.required'   => 'Vui lòng nhập tên phòng.',
            'ten_phong.string'     => 'Tên phòng phải là chuỗi ký tự.',
            'ten_phong.max'        => 'Tên phòng không được vượt quá 100 ký tự.',

            'id_phim.required'     => 'Vui lòng chọn phim.',
            'id_phim.exists'       => 'Phim không tồn tại trong hệ thống.',

            'tinh_trang.required'  => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'   => 'Tình trạng phải là true hoặc false.',
        ];
    }

}
