<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNhanVien extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ten_nhan_vien' => 'required|string|max:100',
            'ngay_sinh'     => 'required|date|before:today',
            'sdt'           => 'required|regex:/^0[0-9]{9}$/',
            'email'         => ['required', 'email', 'max:255', Rule::unique('nhan_viens')->ignore($this->id)],
            'password'      => 'nullable|string|min:6',
            'ngay_bat_dau'  => 'required|date',
            'id_chuc_vu'    => 'required|exists:chuc_vus,id',
            'tinh_trang'    => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'ten_nhan_vien.required' => 'Vui lòng nhập tên nhân viên.',
            'ten_nhan_vien.string'   => 'Tên nhân viên phải là chuỗi.',
            'ten_nhan_vien.max'      => 'Tên nhân viên không được vượt quá 100 ký tự.',

            'ngay_sinh.required'     => 'Vui lòng nhập ngày sinh.',
            'ngay_sinh.date'         => 'Ngày sinh không hợp lệ.',
            'ngay_sinh.before'       => 'Ngày sinh phải trước ngày hôm nay.',

            'sdt.required'           => 'Vui lòng nhập số điện thoại.',
            'sdt.regex'              => 'Số điện thoại không hợp lệ (bắt đầu bằng 0 và đủ 10 số).',

            'email.required'         => 'Vui lòng nhập email.',
            'email.email'            => 'Email không đúng định dạng.',
            'email.max'              => 'Email không được vượt quá 255 ký tự.',
            'email.unique'           => 'Email này đã được sử dụng trong hệ thống.',

            'password.min'           => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'ngay_bat_dau.required'  => 'Vui lòng nhập ngày bắt đầu làm việc.',
            'ngay_bat_dau.date'      => 'Ngày bắt đầu làm việc không hợp lệ.',

            'id_chuc_vu.required'    => 'Vui lòng chọn chức vụ.',
            'id_chuc_vu.exists'      => 'Chức vụ không tồn tại.',

            'tinh_trang.required'    => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'     => 'Tình trạng phải là true hoặc false.',
        ];
    }
}
