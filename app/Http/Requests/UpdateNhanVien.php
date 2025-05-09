<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNhanVien extends FormRequest
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
            'ten_nhan_vien' => 'required|string|max:100',
            'ngay_sinh'     => 'required|date|before:today',
            'sdt'           => 'required|regex:/^0[0-9]{9}$/',
            'email'         => 'required|email|max:255',
            'password'      => 'nullable|string|min:6',
            'ngay_bat_dau'  => 'required|date',
            'id_chuc_vu'    => 'required|exists:chuc_vus,id',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tinh_trang'    => 'required|boolean',
            'is_master'     => 'required|boolean',
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

            'password.min'           => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'ngay_bat_dau.required'  => 'Vui lòng nhập ngày bắt đầu làm việc.',
            'ngay_bat_dau.date'      => 'Ngày bắt đầu làm việc không hợp lệ.',

            'id_chuc_vu.required'    => 'Vui lòng chọn chức vụ.',
            'id_chuc_vu.exists'      => 'Chức vụ không tồn tại.',

            'avatar.image'           => 'Avatar phải là tệp hình ảnh.',
            'avatar.mimes'           => 'Avatar phải có định dạng jpg, jpeg hoặc png.',
            'avatar.max'             => 'Avatar không được vượt quá 2MB.',

            'tinh_trang.required'    => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'     => 'Tình trạng phải là true hoặc false.',

            'is_master.required'     => 'Vui lòng xác định quyền quản trị.',
            'is_master.boolean'      => 'Quyền quản trị phải là true hoặc false.',
        ];
    }

}
