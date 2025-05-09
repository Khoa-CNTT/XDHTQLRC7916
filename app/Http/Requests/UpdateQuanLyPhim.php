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
            'ten_phim'           => 'required|string|max:255',
            'slug_phim'          => 'required|string|max:255|unique:quan_ly_phims,slug_phim,' . $this->route('phim'),
            'ngay_chieu'         => 'required|date',
            'thoi_luong'         => 'required|integer|min:1',
            'dao_dien'           => 'nullable|string|max:100',
            'hinh_anh'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'trailer_ytb'        => 'nullable|url|max:255',
            'dien_vien'          => 'nullable|string|max:255',
            'nha_san_xuat'       => 'nullable|string|max:255',
            'id_the_loai'        => 'required|exists:the_loais,id',
            'gioi_han_do_tuoi'   => 'required|integer|min:0',
            'mo_ta'              => 'nullable|string',
            'danh_gia'           => 'nullable|numeric|min:0|max:10',
            'tinh_trang'         => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'ten_phim.required'         => 'Vui lòng nhập tên phim.',
            'ten_phim.max'              => 'Tên phim không được vượt quá 255 ký tự.',

            'slug_phim.required'        => 'Vui lòng nhập slug phim.',
            'slug_phim.unique'          => 'Slug phim đã tồn tại.',
            'slug_phim.max'             => 'Slug phim không được vượt quá 255 ký tự.',

            'ngay_chieu.required'       => 'Vui lòng nhập ngày chiếu.',
            'ngay_chieu.date'           => 'Ngày chiếu không hợp lệ.',

            'thoi_luong.required'       => 'Vui lòng nhập thời lượng phim.',
            'thoi_luong.integer'        => 'Thời lượng phải là số nguyên.',
            'thoi_luong.min'            => 'Thời lượng phải lớn hơn 0 phút.',

            'dao_dien.max'              => 'Tên đạo diễn không được vượt quá 100 ký tự.',

            'hinh_anh.image'            => 'Hình ảnh phải là tệp ảnh.',
            'hinh_anh.mimes'            => 'Hình ảnh phải có định dạng jpg, jpeg, hoặc png.',
            'hinh_anh.max'              => 'Hình ảnh không được vượt quá 2MB.',

            'trailer_ytb.url'           => 'Trailer phải là URL hợp lệ.',
            'trailer_ytb.max'           => 'Link trailer không được quá 255 ký tự.',

            'dien_vien.max'             => 'Danh sách diễn viên không được vượt quá 255 ký tự.',
            'nha_san_xuat.max'          => 'Nhà sản xuất không được vượt quá 255 ký tự.',

            'id_the_loai.required'      => 'Vui lòng chọn thể loại.',
            'id_the_loai.exists'        => 'Thể loại không tồn tại.',

            'gioi_han_do_tuoi.required' => 'Vui lòng nhập giới hạn độ tuổi.',
            'gioi_han_do_tuoi.integer'  => 'Giới hạn độ tuổi phải là số nguyên.',
            'gioi_han_do_tuoi.min'      => 'Giới hạn độ tuổi không được âm.',

            'danh_gia.numeric'          => 'Đánh giá phải là số.',
            'danh_gia.min'              => 'Đánh giá không được nhỏ hơn 0.',
            'danh_gia.max'              => 'Đánh giá không được lớn hơn 10.',

            'tinh_trang.required'       => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'        => 'Tình trạng phải là true hoặc false.',
        ];
    }


}
