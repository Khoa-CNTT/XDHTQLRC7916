<?php

namespace App\Http\Controllers;

use App\Models\ChiTietVe;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TestControllert extends Controller
{
    public function index()
    {
        $phims = DB::table('quan_ly_phims as p')
            ->leftJoin('chi_tiet_the_loais as cttl', 'p.id', '=', 'cttl.id_phim')
            ->leftJoin('the_loais as tl', 'cttl.id_the_loai', '=', 'tl.id')
            ->leftJoin('suat_chieus as sc', 'p.id', '=', 'sc.phim_id')
            ->leftJoin('phongs as ph', 'sc.phong_id', '=', 'ph.id')
            ->leftJoin('chi_tiet_ves as ctv', 'sc.id', '=', 'ctv.id_suat')
            ->leftJoin('ghes as g', 'ctv.id_ghe', '=', 'g.id')
            ->leftJoin('hoa_dons as hd', 'ctv.id_hoa_don', '=', 'hd.id')
            ->leftJoin('baners as b', 'p.id', '=', 'b.id_phim')
            ->select([
                'p.*',
                'tl.id as the_loai_id',
                'tl.ten_the_loai',
                'sc.id as suat_chieu_id',
                'sc.ngay_chieu',
                'sc.gio_bat_dau',
                'sc.gia_ve',
                'ph.ten_phong',
                'ctv.id as chi_tiet_ve_id',
                'ctv.gia_tien as chi_tiet_gia_ve',
                'g.ten_ghe',
                'g.hang',
                'g.cot',
                'hd.ma_hoa_don',
                'b.hinh_anh as baner_hinh_anh',
                'p.dao_dien',
                'p.dien_vien',
                'p.nha_san_xuat',
                'p.mo_ta',
                'p.gioi_han_do_tuoi'
            ])
            ->get()
            ->groupBy('id');

        $phims->transform(function ($group) {
            $phim = $group->first();
            $phim->danh_sach_ve = $group->map(function ($item) {
                return [
                    'suat_chieu_id' => $item->suat_chieu_id,
                    'ngay_chieu' => $item->ngay_chieu,
                    'gio_bat_dau' => $item->gio_bat_dau,
                    'gia_ve' => $item->gia_ve,
                    'ten_phong' => $item->ten_phong,
                    'chi_tiet_ve_id' => $item->chi_tiet_ve_id,
                    'gia_ve_chi_tiet' => $item->chi_tiet_gia_ve,
                    'ten_ghe' => $item->ten_ghe,
                    'ma_hoa_don' => $item->ma_hoa_don,
                ];
            })->values();

            // Add movie details
            $phim->chi_tiet_phim = [
                'dao_dien' => $phim->dao_dien,
                'dien_vien' => $phim->dien_vien,
                'nha_san_xuat' => $phim->nha_san_xuat,
                'mo_ta' => $phim->mo_ta,
                'gioi_han_do_tuoi' => $phim->gioi_han_do_tuoi
            ];

            return $phim;
        });
        return response()->json($phims);
    }

    function buildPhimQueryFromJson(array $filterJson)
    {
        $query = DB::table('quan_ly_phims as p')
            ->leftJoin('suat_chieus as sc', 'p.id', '=', 'sc.phim_id')
            ->leftJoin('phongs as ph', 'sc.phong_id', '=', 'ph.id')
            ->leftJoin('chi_tiet_ves as ctv', 'sc.id', '=', 'ctv.id_suat')
            ->select(
                'p.ten_phim',
                'p.dao_dien',
                'p.dien_vien',
                'p.nha_san_xuat',
                'p.mo_ta',
                'p.gioi_han_do_tuoi',
                'sc.id as suat_chieu_id',
                'sc.ngay_chieu',
                'sc.gio_bat_dau',
                DB::raw('COUNT(CASE WHEN ctv.tinh_trang = 0 THEN 1 END) as tong_so_ve'),
                DB::raw('COUNT(CASE WHEN ctv.tinh_trang = 1 THEN 1 END) as so_ve_da_ban'),
                DB::raw('COUNT(CASE WHEN ctv.tinh_trang = 0 THEN 1 END) - COUNT(CASE WHEN ctv.tinh_trang = 1 THEN 1 END) as so_ve_trong')
            )
            ->groupBy('sc.id', 'p.ten_phim', 'sc.ngay_chieu', 'sc.gio_bat_dau', 'p.dao_dien', 'p.dien_vien', 'p.nha_san_xuat', 'p.mo_ta', 'p.gioi_han_do_tuoi');

        // Áp dụng bộ lọc nếu có
        foreach ($filterJson as $key => $value) {
            if (is_null($value)) continue;
            switch ($key) {
                case 'ten_phim':
                    $query->where('p.ten_phim', 'like', "%{$value}%");
                    break;
                case 'ngay_chieu':
                    $query->whereDate('sc.ngay_chieu', $value);
                    break;
                case 'gio_bat_dau':
                    $query->whereTime('sc.gio_bat_dau', $value);
                    break;
                case 'dao_dien':
                    $query->where('p.dao_dien', 'like', "%{$value}%");
                    break;
                case 'dien_vien':
                    $query->where('p.dien_vien', 'like', "%{$value}%");
                    break;
                case 'nha_san_xuat':
                    $query->where('p.nha_san_xuat', 'like', "%{$value}%");
                    break;
                case 'gioi_han_do_tuoi':
                    $query->where('p.gioi_han_do_tuoi', $value);
                    break;
            }
        }

        return $query->get();
    }

    public function buildDichVuQuery()
    {
        return DB::table('dich_vus')
            ->select([
                'id',
                'ten_dich_vu',
                'gia_tien',
                'tinh_trang',
                'hinh_anh',
                'created_at',
                'updated_at'
            ])
            ->where('tinh_trang', 1)
            ->get();
    }

    public function buildGocDienAnhQuery()
    {
        return DB::table('goc_dien_anhs')
            ->select([
                'id',
                'tieu_de',
                'noi_dung',
                'hinh_anh',
                'ngay_dang',
                'trang_thai',
                'created_at',
                'updated_at'
            ])
            ->where('trang_thai', 1)
            ->orderBy('ngay_dang', 'desc')
            ->get();
    }

    public function buildSuKienQuery()
    {
        $today = Carbon::now()->toDateString();
        return DB::table('su_kiens')
            ->select([
                'id',
                'ten_su_kien',
                'ngay_bat_dau',
                'ngay_ket_thuc',
                'mo_ta',
                'tinh_trang',
                'hinh_anh',
                'created_at',
                'updated_at'
            ])
            ->where('tinh_trang', 1)
            ->where('ngay_ket_thuc', '>=', $today)
            ->orderBy('ngay_bat_dau', 'asc')
            ->get();
    }

    public function analyzeUserQuery(Request $request)
    {
        $userInput = $request->input('message');
        $today = now()->toDateString();

        // Get data from all sources
        $phimList = null;
        $dichVuList = null;
        $gocDienAnhList = null;
        $suKienList = null;

        $prompt = <<<PROMPT
            Bạn là một trợ lý AI thông minh, có nhiệm vụ hỗ trợ người dùng tìm kiếm thông tin về:
            1. Phim đang chiếu tại rạp
            2. Dịch vụ của rạp
            3. Góc điện ảnh (tin tức)
            4. Sự kiện đang diễn ra

            Hãy phân tích câu hỏi và xác định người dùng đang hỏi về loại thông tin nào.
            Nếu người dùng hỏi về phim đang chiếu, hãy luôn trả về "phim" trong mảng type.
            Nếu người dùng hỏi về chi tiết phim (đạo diễn, diễn viên), hãy trả về "phim" và thêm các trường tương ứng vào phim_filter.

            Trả về JSON theo định dạng sau:
            {
                "type": ["phim", "dich_vu", "goc_dien_anh", "su_kien"],
                "phim_filter": {
                    "ten_phim": null,
                    "the_loai": null,
                    "dao_dien": null,
                    "dien_vien": null,
                    "nha_san_xuat": null,
                    "ngay_chieu": "$today",
                    "gio_bat_dau": null,
                    "gioi_han_do_tuoi": null,
                    "tinh_trang": 1
                }
            }

            Câu hỏi của người dùng: "{$userInput}"

            Lưu ý:
            - Nếu người dùng hỏi về phim đang chiếu, LUÔN trả về ["phim"] trong type
            - Nếu người dùng hỏi về chi tiết phim (đạo diễn, diễn viên), đảm bảo trả về thông tin trong phim_filter
            - Nếu không rõ thời gian, sử dụng ngày hôm nay: "$today"
            - Trả về JSON đúng định dạng, không thêm text
            PROMPT;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        $result = $response->json();

        // Debug logging

        // Trích xuất phản hồi JSON an toàn
        $textResponse = '{}';
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $textResponse = $result['candidates'][0]['content']['parts'][0]['text'];
        }

        $clean = trim($textResponse);
        $clean = Str::replace(['```json', '```'], '', $clean);

        $parsed = json_decode($clean, true);

        // Kiểm tra JSON có hợp lệ không
        if (!is_array($parsed) || !isset($parsed['type'])) {
            return response()->json([
                'message' => 'Không thể phân tích câu hỏi của bạn. Vui lòng thử lại.',
            ]);
        }

        // Lấy dữ liệu dựa trên loại yêu cầu
        $phimList = null;
        $dichVuList = null;
        $gocDienAnhList = null;
        $suKienList = null;

        if (in_array('phim', $parsed['type'])) {
            $phimFilter = $parsed['phim_filter'] ?? [];
            $phimList = $this->buildPhimQueryFromJson($phimFilter);
        }
        if (in_array('dich_vu', $parsed['type'])) {
            $dichVuList = $this->buildDichVuQuery();
        }
        if (in_array('goc_dien_anh', $parsed['type'])) {
            $gocDienAnhList = $this->buildGocDienAnhQuery();
        }
        if (in_array('su_kien', $parsed['type'])) {
            $suKienList = $this->buildSuKienQuery();
        }

        $responseData = [
            'phim' => $phimList ? $phimList->values() : null,
            'dich_vu' => $dichVuList,
            'goc_dien_anh' => $gocDienAnhList,
            'su_kien' => $suKienList,
        ];

        $dataJson = json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Prompt tư vấn người dùng dựa vào dữ liệu
        $tuvanPrompt = <<<PROMPT
            Bạn là một nhân viên thân thiện, chuyên nghiệp của rạp chiếu phim, đang tư vấn cho khách hàng.

            Dưới đây là thông tin về rạp (định dạng JSON):

            ```json
            $dataJson
        ```

        ---

        💬 Câu hỏi của khách:
        "$userInput"

        ---

        🎯 Nhiệm vụ của bạn:
        - Xuống dòng sau mỗi câu
        - Tư vấn rõ ràng về các thông tin được hỏi (phim, dịch vụ, tin tức, sự kiện)
        - Với phim:
          + Nếu hỏi về đạo diễn/diễn viên: cung cấp thông tin chi tiết về đạo diễn, diễn viên
          + Nếu hỏi về lịch chiếu: liệt kê giờ chiếu, số vé còn trống
          + Nếu hỏi về chi tiết phim: cung cấp thông tin về nhà sản xuất, giới hạn độ tuổi, mô tả
        - Với dịch vụ: giới thiệu tên và giá
        - Với góc điện ảnh: tóm tắt tin mới nhất
        - Với sự kiện: thông tin về các sự kiện đang diễn ra
        - Với câu hỏi khác: trả lời thân thiện, không trả lời về phim, dịch vụ, tin tức, sự kiện
        - Văn phong thân thiện như nhân viên tư vấn thật
        - Không trả lại JSON
        - Kết thúc bằng lời mời phù hợp (đặt vé/sử dụng dịch vụ/tham gia sự kiện)
        - Trình bày bằng Markdown gọn gàng, dễ đọc (có thể dùng emoji, tiêu đề phụ, danh sách)
        - Trả lời bám sát message của người dùng
        PROMPT;

        $advise = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
            'contents' => [
                ['parts' => [['text' => $tuvanPrompt]]]
            ]
        ]);

        $message = $advise->json();
        $advisedText = $advise['candidates'][0]['content']['parts'][0]['text'] ?? 'Không thể phản hồi.';

        return response()->json([
            'message' => trim($advisedText),
        ]);
    }
}
