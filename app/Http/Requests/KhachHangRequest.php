<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangRequest extends FormRequest
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
            'ten_khach_hang' => 'required|string|max:255',
            'email' => 'required|email|unique:khach_hangs,email',
            'so_dien_thoai' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            'password' => 'required|string|min:6',
            're_password' => 'required|same:password',
            'ngay_sinh' => 'nullable|date|before:today',
            'is_block' => 'required|in:0,1',
            'is_active' => 'required|in:0,1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'ten_khach_hang.required' => 'Vui lòng nhập tên khách hàng',
            'ten_khach_hang.string' => 'Tên khách hàng phải là chuỗi ký tự',
            'ten_khach_hang.max' => 'Tên khách hàng không được vượt quá 255 ký tự',

            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã tồn tại trong hệ thống',

            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại',
            'so_dien_thoai.regex' => 'Số điện thoại không đúng định dạng',
            'so_dien_thoai.min' => 'Số điện thoại phải có ít nhất 10 số',
            'so_dien_thoai.max' => 'Số điện thoại không được vượt quá 11 số',

            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',

            're_password.required' => 'Vui lòng nhập lại mật khẩu',
            're_password.same' => 'Mật khẩu nhập lại không khớp',

            'ngay_sinh.date' => 'Ngày sinh không đúng định dạng',
            'ngay_sinh.before' => 'Ngày sinh không được lớn hơn ngày hiện tại',

            'is_block.required' => 'Vui lòng chọn tình trạng',
            'is_block.in' => 'Tình trạng không hợp lệ',

            'is_active.required' => 'Vui lòng chọn trạng thái tài khoản',
            'is_active.in' => 'Trạng thái tài khoản không hợp lệ',
        ];
    }
}
