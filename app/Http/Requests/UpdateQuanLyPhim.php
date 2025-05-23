<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuanLyPhim extends FormRequest
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
            'ten_phim'          => 'required|string|max:50',
            'ngay_chieu'        => 'required|date|after:today',
            'slug_phim'         => 'required|string|max:50',
            'thoi_luong'        => 'required|min:1|numeric|min:0',
            'dao_dien'          => 'required|string|min:5',
            'hinh_anh'          => 'required|string|max:255',
            'dien_vien'         => 'required|string|min:5',
            'nha_san_xuat'      => 'required|string|max:50',
            'gioi_han_do_tuoi'  => 'required|integer|min:1',
            'mo_ta'             => 'required|string|min:5',
            'danh_gia'          => 'required|numeric|min:0|lt:11',
            'tinh_trang'        => 'required|boolean',
            'trailer_ytb'       => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'ten_phim.required'                 => 'Tên phim yêu cầu phải nhập',
            'ten_phim.string'                  => 'Tên phim phải là chuỗi ký tự',
            'ten_phim.max'                     => 'Tên phim không quá 50 ký tự',
            'ngay_chieu.required'               => 'Ngày chiếu yêu cầu phải chọn',
            'ngay_chieu.after'                  => 'Ngày bắt đầu phải sau ngày hiện tại',
            'thoi_luong.required'               => 'Thời Lượng yêu cầu phải nhập',
            'thoi_luong.string'                 => 'Thời Lượng phải là chuỗi ký tự',
            'thoi_luong.min'                    => 'Thời Lượng ít nhất phải 1 phút',
            'thoi_luong.numeric'                    => 'Thời Lượng phải là số',
            'dao_dien.required'                 => 'Đạo diễn yêu cầu phải nhập',
            'dao_dien.string'                  => 'Đạo diễn phải là chuỗi ký tự',
            'dao_dien.min'                     => 'Đạo diễn ít nhất 5 kí tự',
            'hinh_anh.required'                 => 'Hình ảnh yêu cầu phải nhập',
            'hinh_anh.string'                  => 'Hình ảnh phải là chuỗi ký tự',
            'hinh_anh.max'                     => 'Hình ảnh không quá 255 ký tự',
            'dien_vien.required'                => 'Diễn viên yêu cầu phải nhập',
            'dien_vien.string'                  => 'Diễn viên phải là chuỗi ký tự',
            'dien_vien.min'                     => 'Diễn viên ít nhất 5 kí tự',
            'nha_san_xuat.required'             => 'Nhà sản xuất yêu cầu phải nhập',
            'nha_san_xuat.string'              => 'Nhà sản xuất phải là chuỗi ký tự',
            'nha_san_xuat.max'                 => 'Nhà sản xuất không quá 50 ký tự',
            'gioi_han_do_tuoi.required'         => 'Giới hạn độ tuổi yêu cầu phải nhập',
            'mo_ta.required'                    => 'Mô tả bát buộc phải nhập',
            'mo_ta.string'                      => 'Mô tả phải là chuỗi ký tự',
            'mo_ta.min'                         => 'Mô tả ít 5 kí tự',
            'danh_gia.required'                 => 'Đánh giá bắt buộc phải  nhập',
            'tinh_trang.required'               => 'Tình Trạng bắt buộc phải nhập',
            'tinh_trang.boolean'               => 'Tình Trạng phải là true hoặc false',
            'trailer_ytb.required'               => 'Trailer yêu cầu phải nhập',
            'trailer_ytb.string'                 => 'Trailer phải là chuỗi ký tự',
            'trailer_ytb.max'                    => 'Trailer không quá 255 ký tự',
            'slug_phim.required'                 => 'Slug phim yêu cầu phải nhập',
            'slug_phim.string'                   => 'Slug phim phải là chuỗi ký tự',
            'slug_phim.max'                      => 'Slug phim không quá 50 ký tự',

            'gioi_han_do_tuoi.integer'         => 'Giới hạn độ tuổi phải là số nguyên',
            'gioi_han_do_tuoi.min'             => 'Giới hạn độ tuổi phải lớn hơn 0',

            'danh_gia.numeric'                 => 'Đánh giá phải là một số',
            'danh_gia.min'                      => 'Đánh giá phải lớn hơn hoặc bằng 0',
            'danh_gia.lt'                      => 'Đánh giá phải nhỏ hơn hoặc bằng 10',

        ];
    }


}
