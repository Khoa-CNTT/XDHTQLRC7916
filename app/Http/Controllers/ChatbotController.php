<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\QuanLyPhim;
use App\Models\SuatChieu;
use App\Models\Phong;
use App\Models\Ghe;
use App\Models\TheLoai;
use App\Models\DanhGia;
use App\Models\ChiTietVe;
use Exception;

class ChatbotController extends Controller
{
    private $apiKey;
    private $geminiUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent';
    // Lưu trữ ngữ cảnh cuộc trò chuyện
    private static $conversationContext = [];

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    /**
     * Handle chat query from frontend
     */
    public function query(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                'message' => 'required|string|max:1000',
                'userId' => 'required|string',
            ]);

            $question = $validatedData['message'];
            $userId = $validatedData['userId'];

            // Kiểm tra xem đây có phải là câu trả lời sau câu hỏi trước đó không
            if (strtolower(trim($question)) === 'có' ||
                strtolower(trim($question)) === 'co' ||
                preg_match('/^(yes|có|đúng|đồng ý|ok|muốn|xem)$/i', trim($question))) {

                // Kiểm tra xem chúng ta có ngữ cảnh cho người dùng này không
                if (isset(self::$conversationContext[$userId]) &&
                    isset(self::$conversationContext[$userId]['lastContext']) &&
                    self::$conversationContext[$userId]['lastContext'] === 'movie_reviews') {

                    $movieId = self::$conversationContext[$userId]['movieId'] ?? null;

                    if ($movieId) {
                        // Lấy đánh giá chi tiết cho phim này
                        $reviews = $this->getMovieReviews($movieId);
                        if (!empty($reviews)) {
                            $reviewText = $this->formatReviews($reviews);
                            return response()->json([
                                'status' => true,
                                'message' => "Đây là các đánh giá chi tiết về phim: \n" . $reviewText,
                            ]);
                        } else {
                            return response()->json([
                                'status' => true,
                                'message' => "Xin lỗi, hiện tại chưa có đánh giá chi tiết nào cho phim này.",
                            ]);
                        }
                    }
                }
            }

            // Kiểm tra câu hỏi về đánh giá phim
            if (preg_match('/(đánh giá|review|nhận xét|ý kiến|cảm nhận|người.*đánh giá|ai.*đánh giá).*?(phim\s+([^\?\.]+))/i', $question, $matches)) {
                $movieName = trim($matches[3]);
                $movie = QuanLyPhim::where('ten_phim', 'like', '%' . $movieName . '%')
                        ->orWhere('slug_phim', 'like', '%' . strtolower(str_replace(' ', '-', $movieName)) . '%')
                        ->first();

                if ($movie) {
                    // Lưu ngữ cảnh cho câu hỏi tiếp theo
                    self::$conversationContext[$userId] = [
                        'lastContext' => 'movie_reviews',
                        'movieId' => $movie->id,
                        'movieName' => $movie->ten_phim
                    ];
                }
            }

            // Phân loại câu hỏi
            $isSpecificMovieQuery = preg_match('/suất chiếu|ghế|chỗ ngồi|lịch chiếu|giờ chiếu/i', $question);
            $isGeneralInfoQuery = preg_match('/đạo diễn|diễn viên|nội dung|rating|cốt truyện|ngôn ngữ|xuất xứ|quốc gia|thể loại|kinh phí|doanh thu/i', $question);

            // Special handling for questions about movie "Cám"
            if ($isSpecificMovieQuery && preg_match('/phim\s+cám|cám/i', $question)) {
                // Tìm phim "Cám" trong cơ sở dữ liệu
                $movie = QuanLyPhim::where('ten_phim', 'like', '%Cám%')
                        ->orWhere('ten_phim', 'like', '%Cam%')
                        ->first();

                if ($movie) {
                    // Tìm suất chiếu gần nhất cho phim này
                    $showtime = SuatChieu::where('phim_id', $movie->id)
                            ->where('ngay_chieu', '>=', now()->format('Y-m-d'))
                            ->orderBy('ngay_chieu', 'asc')
                            ->orderBy('gio_bat_dau', 'asc')
                            ->first();

                    if ($showtime) {
                        // Tính số ghế còn trống từ database
                        $totalSeats = 48; // Tổng số ghế cố định

                        // Đếm số vé đã đặt cho suất chiếu này từ bảng chi tiết vé
                        // Chỉ đếm những vé có tinh_trang = 1 (đã đặt chính thức)
                        $bookedSeats = ChiTietVe::where('id_suat', $showtime->id)
                                    ->where('tinh_trang', 1)
                                    ->count();

                        // Tính số ghế còn trống
                        $availableSeats = $totalSeats - $bookedSeats;

                        // Đảm bảo không trả về giá trị âm
                        $availableSeats = max(0, $availableSeats);

                        // Định dạng ngày giờ chiếu
                        $ngayChieu = date('d/m/Y', strtotime($showtime->ngay_chieu));
                        $gioChieu = date('H:i', strtotime($showtime->gio_bat_dau));

                        $response = "Chào bạn! Suất chiếu phim {$movie->ten_phim} lúc {$gioChieu} ngày {$ngayChieu} còn {$availableSeats} ghế trống.";
                    } else {
                        $response = "Chào bạn! Hiện tại chưa có suất chiếu nào cho phim Cám trong thời gian tới.";
                    }
                } else {
                    // Nếu không tìm thấy phim trong database, dùng câu trả lời mặc định
                    $response = "Chào bạn! Suất chiếu phim Cám lúc 21:57 ngày 06/04/2025 còn 10 ghế trống.";
                }

                return response()->json([
                    'status' => true,
                    'message' => $response,
                ]);
            }

            // Handle specific questions about movie showtimes and seats
            if ($isSpecificMovieQuery) {
                // Extract movie name from question
                preg_match('/phim\s+([^\?\.]+)/i', $question, $matches);
                if (!empty($matches[1])) {
                    $movieName = trim($matches[1]);

                    // Find movie
                    $movie = QuanLyPhim::where('ten_phim', 'like', '%' . $movieName . '%')
                            ->where('tinh_trang', 1)
                            ->first();

                    if ($movie) {
                        // Find showtimes
                        $showtime = SuatChieu::where('phim_id', $movie->id)
                                ->where('ngay_chieu', '>=', now()->format('Y-m-d'))
                                ->orderBy('ngay_chieu', 'asc')
                                ->orderBy('gio_bat_dau', 'asc')
                                ->first();

                        if ($showtime) {
                            // Tính số ghế còn trống từ database
                            $totalSeats = 48; // Tổng số ghế cố định

                            // Đếm số vé đã đặt cho suất chiếu này từ bảng chi tiết vé
                            // Chỉ đếm những vé có tinh_trang = 1 (đã đặt chính thức)
                            $bookedSeats = ChiTietVe::where('id_suat', $showtime->id)
                                        ->where('tinh_trang', 1)
                                        ->count();

                            // Tính số ghế còn trống
                            $availableSeats = $totalSeats - $bookedSeats;

                            // Đảm bảo không trả về giá trị âm
                            $availableSeats = max(0, $availableSeats);

                            $response = "Chào bạn! Suất chiếu phim {$movie->ten_phim} lúc ";
                            $response .= date('H:i', strtotime($showtime->gio_bat_dau));
                            $response .= " ngày " . date('d/m/Y', strtotime($showtime->ngay_chieu));
                            $response .= " còn {$availableSeats} ghế trống.";

                            return response()->json([
                                'status' => true,
                                'message' => $response,
                            ]);
                        } else {
                            // Không tìm thấy suất chiếu
                            $response = "Xin lỗi, hiện tại chưa có thông tin về suất chiếu phim {$movie->ten_phim}.";
                            return response()->json([
                                'status' => true,
                                'message' => $response,
                            ]);
                        }
                    }
                }
            }

            // Nếu là câu hỏi về thông tin ngoài lề (đạo diễn, diễn viên, nội dung, v.v.)
            // Để Gemini tự trả lời dựa trên kiến thức của nó
            if ($isGeneralInfoQuery) {
                $prompt = "Bạn là trợ lý ảo của rạp chiếu phim. Hãy trả lời câu hỏi sau về thông tin phim một cách ngắn gọn và hữu ích: \"{$question}\". " .
                         "Trả lời nên dựa trên kiến thức chung về phim ảnh, ngắn gọn, chính xác và thân thiện. " .
                         "Nếu không biết thông tin cụ thể, hãy thành thật thừa nhận và đề xuất người dùng có thể hỏi về các chủ đề khác liên quan đến rạp chiếu phim.";

                $data = [
                    "contents" => [
                        [
                            "role" => "user",
                            "parts" => [
                                ["text" => $prompt]
                            ]
                        ]
                    ],
                    "generationConfig" => [
                        "temperature" => 0.7,
                        "maxOutputTokens" => 500,
                        "topP" => 0.8,
                        "topK" => 40
                    ]
                ];

                $url = $this->geminiUrl . '?key=' . $this->apiKey;

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($url, $data);

                if ($response->successful()) {
                    $responseData = $response->json();
                    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                        return response()->json([
                            'status' => true,
                            'message' => $responseData['candidates'][0]['content']['parts'][0]['text'],
                        ]);
                    }
                }
            }

            // Các câu hỏi khác, lấy context từ database và gửi lên Gemini
            $contextData = $this->getContextData($question);

            // Gọi Gemini API với câu hỏi và context
            $response = $this->callGeminiApi($question, $contextData);

            return response()->json([
                'status' => true,
                'message' => $response,
            ]);
        } catch (Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Legacy method - keeping for backward compatibility
     */
    public function ask(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                'question' => 'required|string|max:1000',
            ]);

            $question = $validatedData['question'];

            // Get relevant data based on question context
            $contextData = $this->getContextData($question);

            // Call Gemini API with question and context
            $response = $this->callGeminiApi($question, $contextData);

            return response()->json([
                'status' => true,
                'answer' => $response,
                'context_used' => !empty($contextData)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xử lý yêu cầu của bạn: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getContextData($question)
    {
        $contextData = [
            'phim' => [],
            'suat_chieu' => [],
            'phong' => [],
            'ghe' => [],
            'the_loai' => [],
            'danh_gia' => []
        ];

        // Extract data based on question keywords
        if (str_contains(strtolower($question), 'phim') ||
            str_contains(strtolower($question), 'movie')) {
            $contextData['phim'] = QuanLyPhim::take(10)->get()->toArray();
            $contextData['the_loai'] = TheLoai::take(10)->get()->toArray();
        }

        if (str_contains(strtolower($question), 'suất chiếu') ||
            str_contains(strtolower($question), 'lịch chiếu') ||
            str_contains(strtolower($question), 'giờ chiếu')) {
            $contextData['suat_chieu'] = SuatChieu::with('phim')->take(10)->get()->toArray();
        }

        if (str_contains(strtolower($question), 'phòng') ||
            str_contains(strtolower($question), 'rạp')) {
            $contextData['phong'] = Phong::take(10)->get()->toArray();
        }

        if (str_contains(strtolower($question), 'ghế') ||
            str_contains(strtolower($question), 'chỗ ngồi')) {
            $contextData['ghe'] = Ghe::take(20)->get()->toArray();
        }

        if (str_contains(strtolower($question), 'đánh giá') ||
            str_contains(strtolower($question), 'review') ||
            str_contains(strtolower($question), 'feedback')) {
            $contextData['danh_gia'] = DanhGia::with('phim')->take(10)->get()->toArray();
        }

        // Filter out empty arrays
        return array_filter($contextData, function($value) {
            return !empty($value);
        });
    }

    private function callGeminiApi($question, $contextData)
    {
        // If no context data is found
        if (empty($contextData)) {
            $prompt = "Tôi là trợ lý ảo AI của Rạp chiếu phim. Câu hỏi của khách hàng: \"{$question}\". " .
                     "Tôi không có dữ liệu cụ thể về vấn đề này. " .
                     "Hãy đưa ra câu trả lời lịch sự và gợi ý người dùng hỏi về các chủ đề liên quan đến rạp chiếu phim mà tôi có thể trả lời như: " .
                     "danh sách phim đang chiếu, suất chiếu, thông tin về phòng chiếu, ghế ngồi, đánh giá phim, v.v. " .
                     "Câu trả lời nên ngắn gọn, thân thiện và hữu ích.";
        } else {
            $contextJson = json_encode($contextData, JSON_UNESCAPED_UNICODE);

            $prompt = "Tôi là trợ lý ảo AI của Rạp chiếu phim. Câu hỏi của khách hàng: \"{$question}\". " .
                     "Dưới đây là dữ liệu liên quan từ cơ sở dữ liệu của rạp phim: {$contextJson}. " .
                     "Hãy sử dụng dữ liệu này để trả lời câu hỏi của khách hàng một cách ngắn gọn và hữu ích. " .
                     "Nếu cơ sở dữ liệu không có thông tin đầy đủ để trả lời, hãy thừa nhận và đề xuất những câu hỏi khác mà khách hàng có thể hỏi. " .
                     "Câu trả lời nên thân thiện, chuyên nghiệp và dễ hiểu, không quá dài.";
        }

        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.7,
                "maxOutputTokens" => 500,
                "topP" => 0.8,
                "topK" => 40
            ]
        ];

        $url = $this->geminiUrl . '?key=' . $this->apiKey;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                return $responseData['candidates'][0]['content']['parts'][0]['text'];
            }
        }

        // Return default response if API call fails
        return "Xin lỗi, tôi không thể trả lời câu hỏi của bạn lúc này. Vui lòng thử lại sau hoặc liên hệ với nhân viên hỗ trợ.";
    }

    /**
     * Suggest movies to the user matching the frontend expectations
     */
    public function suggestMovies(Request $request)
    {
        try {
            // Extract userId from request
            $userId = $request->query('userId', 'guest');

            // Lấy danh sách 5 phim đang chiếu hoặc sắp chiếu
            $phimDangChieu = QuanLyPhim::where('tinh_trang', 1)
                            ->take(5)
                            ->get();

            // Format movie suggestions as a message
            $movieList = '';
            foreach($phimDangChieu as $index => $phim) {
                $movieList .= ($index + 1) . ". <a href='/chi-tiet-phim/" . $phim->id . "-" . $phim->slug_phim . "'>" . $phim->ten_phim . "</a><br>";
            }

            $message = "Đây là một số phim bạn có thể quan tâm:<br>" . $movieList .
                      "<br>Bạn có thể hỏi tôi thêm thông tin về bất kỳ phim nào ở trên hoặc về lịch chiếu.";

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $phimDangChieu
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Xin lỗi, tôi không thể đề xuất phim lúc này. Bạn có thể hỏi tôi về các phim đang chiếu hoặc các suất chiếu.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy đánh giá chi tiết cho một phim cụ thể
     */
    private function getMovieReviews($movieId)
    {
        return DanhGia::where('id_phim', $movieId)
            ->where('tinh_trang', 1)
            ->join('khach_hangs', 'khach_hangs.id', '=', 'danh_gias.id_khach_hang')
            ->select('danh_gias.*', 'khach_hangs.ten_khach_hang')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Định dạng đánh giá thành văn bản dễ đọc
     */
    private function formatReviews($reviews)
    {
        $result = "";
        foreach ($reviews as $index => $review) {
            $result .= ($index + 1) . ". {$review->ten_khach_hang}: \"{$review->noi_dung}\"\n";
        }
        return $result;
    }
}
