<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangDatLaiMatKhauRequest extends FormRequest
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
            'password' => 'required|min:6|max:255',
            're_password' => 'required|min:6|max:255|same:password',
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự',
            're_password.required' => 'Mật khẩu không được để trống',
            're_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            're_password.max' => 'Mật khẩu không được vượt quá 255 ký tự',
            're_password.same' => 'Mật khẩu không khớp',
        ];
    }
}
