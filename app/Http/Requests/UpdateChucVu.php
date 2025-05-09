<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChucVu extends FormRequest
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
            'ten_chuc_vu' => 'required|string|max:255',
            'is_master'   => 'required|boolean',
            'tinh_trang'  => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_chuc_vu.required' => 'Vui lòng nhập tên chức vụ.',
            'ten_chuc_vu.string'   => 'Tên chức vụ phải là chuỗi ký tự.',
            'ten_chuc_vu.max'      => 'Tên chức vụ không được vượt quá 255 ký tự.',

            'is_master.required'   => 'Vui lòng chọn quyền is_master.',
            'is_master.boolean'    => 'is_master phải là true hoặc false.',

            'tinh_trang.required'  => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'   => 'Tình trạng phải là true hoặc false.',
        ];
    }


}
