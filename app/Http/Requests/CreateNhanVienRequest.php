<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNhanVienRequest extends FormRequest
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
            'sdt'           => 'required|digits_between:9,11',
            'email'         => 'required|email|unique:nhan_viens,email',
            'password'      => 'required|string|min:6',
            'ngay_bat_dau'  => 'required|date|after_or_equal:ngay_sinh',
            'id_chuc_vu'    => 'required|exists:chuc_vus,id',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'tinh_trang'    => 'required|boolean',
            'is_master'     => 'required|boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'ten_nhan_vien.required' => 'Tên nhân viên không được để trống.',
            'ten_nhan_vien.string'   => 'Tên nhân viên phải là chuỗi.',
            'ten_nhan_vien.max'      => 'Tên nhân viên không quá 100 ký tự.',

            'ngay_sinh.required'     => 'Vui lòng nhập ngày sinh.',
            'ngay_sinh.date'         => 'Ngày sinh phải đúng định dạng.',
            'ngay_sinh.before'       => 'Ngày sinh phải trước ngày hôm nay.',

            'sdt.required'           => 'Vui lòng nhập số điện thoại.',
            'sdt.digits_between'     => 'Số điện thoại phải từ 9 đến 11 chữ số.',

            'email.required'         => 'Vui lòng nhập email.',
            'email.email'            => 'Email không hợp lệ.',
            'email.unique'           => 'Email đã tồn tại.',

            'password.required'      => 'Vui lòng nhập mật khẩu.',
            'password.min'           => 'Mật khẩu phải từ 6 ký tự trở lên.',

            'ngay_bat_dau.required'  => 'Vui lòng nhập ngày bắt đầu làm việc.',
            'ngay_bat_dau.date'      => 'Ngày bắt đầu không hợp lệ.',
            'ngay_bat_dau.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày sinh.',

            'id_chuc_vu.required'    => 'Vui lòng chọn chức vụ.',
            'id_chuc_vu.exists'      => 'Chức vụ không tồn tại.',

            'avatar.image'           => 'Avatar phải là ảnh.',
            'avatar.mimes'           => 'Avatar phải có định dạng jpg, jpeg, png hoặc gif.',
            'avatar.max'             => 'Kích thước avatar tối đa là 2MB.',

            'tinh_trang.required'    => 'Vui lòng chọn trạng thái.',
            'tinh_trang.boolean'     => 'Trạng thái phải là true hoặc false.',

            'is_master.required'     => 'Vui lòng chọn quyền.',
            'is_master.boolean'      => 'Quyền phải là true hoặc false.'
        ];
    }

}
