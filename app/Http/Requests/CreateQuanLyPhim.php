<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuanLyPhim extends FormRequest
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
            'ten_phim'          => 'required|between:5,50',
            'ngay_chieu'        => 'required|date|after:today',
            'slug_phim'         => 'required',
            'thoi_luong'        => 'required',
            'dao_dien'          => 'required|between:5,50',
            'hinh_anh'          => 'required',
            'baner1'          => 'required',
            'baner2'          => 'required',
            'baner3'          => 'required',
            'dien_vien'         => 'required|between:5,50',
            'nha_san_xuat'      => 'required',
            'id_the_loai'       => 'required',
            'gioi_han_do_tuoi'  => 'required|between:5,50',
            'mo_ta'             => 'required|max:255',
            'danh_gia'          => 'required|max:255',
            'tinh_trang'        => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'ten_phim.required'                 => 'Tên phim yêu cầu phải nhập',
            'ten_phim.between'                  => 'Tên phim phải từ 5 đến 50 ký tự',
            'ngay_chieu.required'               => 'Ngày chiếu yêu cầu phải chọn',
            'ngay_chieu.after'                  => 'Ngày bắt đầu phải sau ngày hiện tại',
            'thoi_luong.required'               => 'Thời Lượng yêu cầu phải nhập',
            'dao_dien.required'                 => 'Đạo diễn yêu cầu phải nhập',
            'dao_dien.between'                  => 'Đạo diễn phải từ 5 đến 50 ký tự',
            'hinh_anh.required'                 => 'Hình ảnh yêu cầu phải nhập',
            'dien_vien.between'                 => 'Diễn viên phải từ 5 đến 50 ký tự',
            'dien_vien.required'                => 'Diễn viên yêu cầu phải nhập',
            'nha_san_xuat.required'             => 'Nhà sản xuất yêu cầu phải nhập',
            'id_the_loai.required'              => 'Thể loại yêu cầu phải nhập',
            'gioi_han_do_tuoi'                  => 'Giới hạn độ tuổi yêu cầu phải nhập',
            'gioi_han_do_tuoi.between'          => 'Giới hạn độ tuổi phải từ 5 đến 50 ký tự',
            'mo_ta.required'                    => 'Mô tả bát buộc phải nhập',
            'mo_ta.max'                         => 'Mô tả không quá 255 kí tự',
            'danh_gia.required'                 => 'Đánh giá bắt buộc phải  nhập',
            'danh_gia.max'                      => 'Đánh giá không quá 255 kí tự',
            'tinh_trang.required'               => 'Tình Trạng bắt buộc phải nhập',
        ];
    }


}
