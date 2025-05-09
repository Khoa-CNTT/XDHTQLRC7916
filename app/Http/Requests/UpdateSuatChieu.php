<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuatChieu extends FormRequest
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
            'phim_id'       => 'required|exists:quan_ly_phims,id',
            'phong_id'      => 'required|exists:phongs,id',
            'ngay_chieu'    => 'required|date',
            'gio_bat_dau'   => 'required|date_format:H:i',
            'gio_ket_thuc'  => 'required|date_format:H:i|after:gio_bat_dau',
            'gia_ve'        => 'required|numeric|min:0',
            'trang_thai'    => 'required|boolean',
            'dinh_dang'     => 'required|',
            'ngon_ngu'      => 'required|',
        ];
    }
    public function messages(): array
    {
        return [
            'phim_id.required'        => 'Vui lòng chọn phim.',
            'phim_id.exists'          => 'Phim không tồn tại.',

            'phong_id.required'       => 'Vui lòng chọn phòng chiếu.',
            'phong_id.exists'         => 'Phòng chiếu không tồn tại.',

            'ngay_chieu.required'     => 'Vui lòng nhập ngày chiếu.',
            'ngay_chieu.date'         => 'Ngày chiếu không hợp lệ.',

            'gio_bat_dau.required'    => 'Vui lòng nhập giờ bắt đầu.',
            'gio_bat_dau.date_format' => 'Giờ bắt đầu phải đúng định dạng HH:mm.',

            'gio_ket_thuc.required'    => 'Vui lòng nhập giờ kết thúc.',
            'gio_ket_thuc.date_format' => 'Giờ kết thúc phải đúng định dạng HH:mm.',
            'gio_ket_thuc.after'       => 'Giờ kết thúc phải sau giờ bắt đầu.',

            'gia_ve.required'         => 'Vui lòng nhập giá vé.',
            'gia_ve.numeric'          => 'Giá vé phải là số.',
            'gia_ve.min'              => 'Giá vé không được âm.',

            'trang_thai.required'     => 'Vui lòng chọn trạng thái.',
            'trang_thai.boolean'      => 'Trạng thái phải là true hoặc false.',

            'dinh_dang.required'      => 'Vui lòng nhập định dạng.',
            

            'ngon_ngu.required'       => 'Vui lòng nhập ngôn ngữ.',
            
        ];
    }

}
