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
            'thoi_luong'        => 'required|string|max:50',
            'dao_dien'          => 'required|string|max:50',
            'hinh_anh'          => 'required|string|max:255',
            'baner1'          => 'required|string|max:255',
            'baner2'          => 'required|string|max:255',
            'baner3'          => 'required|string|max:255',
            'dien_vien'         => 'required|string|max:50',
            'nha_san_xuat'      => 'required|string|max:50',
            'id_the_loai'       => 'required|string|max:50',
            'gioi_han_do_tuoi'  => 'required|string|max:50',
            'mo_ta'             => 'required|string|max:255',
            'danh_gia'          => 'required|string|max:255',
            'tinh_trang'        => 'required|boolean',
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
            'thoi_luong.max'                    => 'Thời Lượng không quá 50 ký tự',
            'dao_dien.required'                 => 'Đạo diễn yêu cầu phải nhập',
            'dao_dien.string'                  => 'Đạo diễn phải là chuỗi ký tự',
            'dao_dien.max'                     => 'Đạo diễn không quá 50 ký tự',
            'hinh_anh.required'                 => 'Hình ảnh yêu cầu phải nhập',
            'hinh_anh.string'                  => 'Hình ảnh phải là chuỗi ký tự',
            'hinh_anh.max'                     => 'Hình ảnh không quá 255 ký tự',
            'dien_vien.required'                => 'Diễn viên yêu cầu phải nhập',
            'dien_vien.string'                  => 'Diễn viên phải là chuỗi ký tự',
            'dien_vien.max'                     => 'Diễn viên không quá 50 ký tự',
            'nha_san_xuat.required'             => 'Nhà sản xuất yêu cầu phải nhập',
            'nha_san_xuat.string'              => 'Nhà sản xuất phải là chuỗi ký tự',
            'nha_san_xuat.max'                 => 'Nhà sản xuất không quá 50 ký tự',
            'id_the_loai.required'              => 'Thể loại yêu cầu phải nhập',
            'gioi_han_do_tuoi.required'         => 'Giới hạn độ tuổi yêu cầu phải nhập',
            'gioi_han_do_tuoi.string'           => 'Giới hạn độ tuổi phải là chuỗi ký tự',
            'gioi_han_do_tuoi.max'              => 'Giới hạn độ tuổi không quá 50 ký tự',
            'mo_ta.required'                    => 'Mô tả bát buộc phải nhập',
            'mo_ta.string'                      => 'Mô tả phải là chuỗi ký tự',
            'mo_ta.max'                         => 'Mô tả không quá 255 kí tự',
            'danh_gia.required'                 => 'Đánh giá bắt buộc phải  nhập',
            'danh_gia.string'                  => 'Đánh giá phải là chuỗi ký tự',
            'danh_gia.max'                     => 'Đánh giá không quá 255 kí tự',
            'tinh_trang.required'               => 'Tình Trạng bắt buộc phải nhập',
            'tinh_trang.boolean'               => 'Tình Trạng phải là true hoặc false',
            'baner1.required'                   => 'Banner 1 yêu cầu phải nhập',
            'baner1.string'                     => 'Banner 1 phải là chuỗi ký tự',
            'baner1.max'                        => 'Banner 1 không quá 255 ký tự',
            'baner2.required'                   => 'Banner 2 yêu cầu phải nhập',
            'baner2.string'                     => 'Banner 2 phải là chuỗi ký tự',
            'baner2.max'                        => 'Banner 2 không quá 255 ký tự',
            'baner3.required'                   => 'Banner 3 yêu cầu phải nhập',
            'baner3.string'                     => 'Banner 3 phải là chuỗi ký tự',
            'baner3.max'                        => 'Banner 3 không quá 255 ký tự',
            'trailer_ytb.required'               => 'Trailer yêu cầu phải nhập',
            'trailer_ytb.string'                 => 'Trailer phải là chuỗi ký tự',
            'trailer_ytb.max'                    => 'Trailer không quá 255 ký tự',
            'slug_phim.required'                 => 'Slug phim yêu cầu phải nhập',
            'slug_phim.string'                   => 'Slug phim phải là chuỗi ký tự',
            'slug_phim.max'                      => 'Slug phim không quá 50 ký tự',
            'id_the_loai.required'               => 'Thể loại yêu cầu phải nhập',
            'id_the_loai.string'                 => 'Thể loại phải là chuỗi ký tự',
            'id_the_loai.max'                    => 'Thể loại không quá 50 ký tự',
            'id_the_loai.exists'                 => 'Thể loại không tồn tại',
            
        ];
    }


}
