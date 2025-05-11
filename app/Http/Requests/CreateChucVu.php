<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChucVu extends FormRequest
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
            'ten_chuc_vu' => 'required|string|max:100',
            'is_master'   => 'required|boolean',
            'tinh_trang'  => 'required|boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'ten_chuc_vu.required' => 'Tên chức vụ không được để trống.',
            'ten_chuc_vu.string'   => 'Tên chức vụ phải là chuỗi.',
            'ten_chuc_vu.max'      => 'Tên chức vụ không được vượt quá 100 ký tự.',

            'is_master.required'   => 'Vui lòng chọn quyền master.',
            'is_master.boolean'    => 'Giá trị quyền master phải là true hoặc false.',

            'tinh_trang.required'  => 'Vui lòng chọn trạng thái.',
            'tinh_trang.boolean'   => 'Trạng thái phải là true hoặc false.',
        ];
    }

}
