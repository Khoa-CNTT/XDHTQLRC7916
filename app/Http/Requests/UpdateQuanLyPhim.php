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
            'ten_phim'           => 'required|string|max:255',
            'slug_phim'          => 'required|string|max:255|unique:quan_ly_phims,slug_phim,' . $this->id . ',id',
            'ngay_chieu'         => 'required|date',
            'thoi_luong'         => 'required|integer|min:1',
            'dao_dien'           => 'required|string|max:100',
            'hinh_anh'           => 'required|string|max:255',
            'trailer_ytb'        => 'required|string|max:255',
            'dien_vien'          => 'required|string|max:255',
            'nha_san_xuat'       => 'required|string|max:255',
            'id_the_loai'        => 'required|exists:the_loais,id',
            'gioi_han_do_tuoi'   => 'required|integer|min:0',
            'mo_ta'              => 'required|string',
            'danh_gia'           => 'required|string',
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
            'slug_phim.string'          => 'Slug phim phải là chuỗi ký tự.',

            'ngay_chieu.required'       => 'Vui lòng nhập ngày chiếu.',
            'ngay_chieu.date'           => 'Ngày chiếu không hợp lệ.',

            'thoi_luong.required'       => 'Vui lòng nhập thời lượng phim.',
            'thoi_luong.integer'        => 'Thời lượng phải là số nguyên.',
            'thoi_luong.min'            => 'Thời lượng phải lớn hơn 0 phút.',

            'dao_dien.max'              => 'Tên đạo diễn không được vượt quá 100 ký tự.',
            'dao_dien.required'         => 'Vui lòng nhập tên đạo diễn.',

            'hinh_anh.string'           => 'Hình ảnh phải là chuỗi ký tự',
            'hinh_anh.max'              => 'Hình ảnh không được vượt quá 255 ký tự',
            'hinh_anh.required'         => 'Vui lòng nhập hình ảnh.',

            'trailer_ytb.string'        => 'Trailer phải là chuỗi ký tự',
            'trailer_ytb.max'           => 'Link trailer không được quá 255 ký tự.',
            'trailer_ytb.required'      => 'Vui lòng nhập link trailer.',

            'dien_vien.max'             => 'Danh sách diễn viên không được vượt quá 255 ký tự.',
            'dien_vien.required'        => 'Vui lòng nhập danh sách diễn viên.',

            'nha_san_xuat.max'          => 'Nhà sản xuất không được vượt quá 255 ký tự.',
            'nha_san_xuat.required'     => 'Vui lòng nhập nhà sản xuất.',

            'id_the_loai.required'      => 'Vui lòng chọn thể loại.',
            'id_the_loai.exists'        => 'Thể loại không tồn tại.',

            'gioi_han_do_tuoi.required' => 'Vui lòng nhập giới hạn độ tuổi.',
            'gioi_han_do_tuoi.integer'  => 'Giới hạn độ tuổi phải là số nguyên.',
            'gioi_han_do_tuoi.min'      => 'Giới hạn độ tuổi không được âm.',


            'danh_gia.required'         => 'Vui lòng nhập đánh giá.',
            'danh_gia.string'           => 'Đánh giá phải là chuỗi ký tự',
            'tinh_trang.required'       => 'Vui lòng chọn tình trạng.',
            'tinh_trang.boolean'        => 'Tình trạng phải là true hoặc false.',
        ];
    }


}
