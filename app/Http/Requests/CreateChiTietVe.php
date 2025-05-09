<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChiTietVe extends FormRequest
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
            'id_suat'        => 'required|exists:suat_chieus,id',
            'id_ghe'         => 'required|exists:ghes,id',
            'gia_ve'         => 'required|numeric|min:0',
            'id_hoa_don'     => 'required|exists:hoa_dons,id',
            'gia_tien'       => 'required|numeric|min:0',
            'id_khach_hang'  => 'required|exists:khach_hangs,id',
            'ghi_chu'        => 'nullable|string|max:255',
            'tinh_trang'     => 'required|boolean'
        ];
    }
    public function messages(): array
    {
        return [
            'id_suat.required'        => 'Vui lòng chọn suất chiếu.',
            'id_suat.exists'          => 'Suất chiếu không tồn tại.',
            'id_ghe.required'         => 'Vui lòng chọn ghế.',
            'id_ghe.exists'           => 'Ghế không tồn tại.',
            'gia_ve.required'         => 'Vui lòng nhập giá vé.',
            'gia_ve.numeric'          => 'Giá vé phải là số.',
            'gia_ve.min'              => 'Giá vé phải lớn hơn hoặc bằng 0.',
            'id_hoa_don.required'     => 'Vui lòng chọn hóa đơn.',
            'id_hoa_don.exists'       => 'Hóa đơn không tồn tại.',
            'gia_tien.required'       => 'Vui lòng nhập giá tiền.',
            'gia_tien.numeric'        => 'Giá tiền phải là số.',
            'gia_tien.min'            => 'Giá tiền phải lớn hơn hoặc bằng 0.',
            'id_khach_hang.required'  => 'Vui lòng chọn khách hàng.',
            'id_khach_hang.exists'    => 'Khách hàng không tồn tại.',
            'ghi_chu.string'          => 'Ghi chú phải là chuỗi.',
            'ghi_chu.max'             => 'Ghi chú không được vượt quá 255 ký tự.',
            'tinh_trang.required'     => 'Vui lòng chọn trạng thái.',
            'tinh_trang.boolean'      => 'Trạng thái phải là true hoặc false.'
        ];
    }

}
