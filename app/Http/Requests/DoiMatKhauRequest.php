<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoiMatKhauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'password' => 'required',
            'moi' => 'required|min:4',
            're_password' => 'required|same: password',
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'moi.required' => 'Vui lòng nhập mật khẩu mới.',
            'moi.min' => 'Mật khẩu mới phải có ít nhất 4 ký tự.',
            're_password.required' => 'Vui lòng nhập lại mật khẩu mới.',
            're_password.same' => 'Nhập lại mật khẩu không khớp với mật khẩu mới.',
        ];
    }
}
