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
use App\Models\HoaDon;
use App\Models\DichVu;
use App\Models\ChiTietTheLoai;
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

            // Prepare context data
            $contextData = [];

            // Handle "yes/no" responses to previous questions
            if (strtolower(trim($question)) === 'có' ||
                strtolower(trim($question)) === 'co' ||
                preg_match('/^(yes|có|đúng|đồng ý|ok|muốn|xem)$/i', trim($question))) {

                if (isset(self::$conversationContext[$userId]) &&
                    isset(self::$conversationContext[$userId]['lastContext']) &&
                    self::$conversationContext[$userId]['lastContext'] === 'movie_reviews') {

                    $movieId = self::$conversationContext[$userId]['movieId'] ?? null;

                    if ($movieId) {
                        $reviews = $this->getMovieReviews($movieId);
                        $contextData['reviews'] = $reviews;
                        $contextData['movieName'] = self::$conversationContext[$userId]['movieName'];
                    }
                }
            }

            // Check for movie reviews questions
            if (preg_match('/(đánh giá|review|nhận xét|ý kiến|cảm nhận|người.*đánh giá|ai.*đánh giá).*?(phim\s+([^\?\.]+))/i', $question, $matches)) {
                $movieName = trim($matches[3]);
                $movie = QuanLyPhim::where('ten_phim', 'like', '%' . $movieName . '%')
                        ->orWhere('slug_phim', 'like', '%' . strtolower(str_replace(' ', '-', $movieName)) . '%')
                        ->first();

                if ($movie) {
                    self::$conversationContext[$userId] = [
                        'lastContext' => 'movie_reviews',
                        'movieId' => $movie->id,
                        'movieName' => $movie->ten_phim
                    ];
                    $contextData['movie'] = $movie;
                }
            }

            // Handle specific movie queries
            if (preg_match('/suất chiếu|ghế|chỗ ngồi|lịch chiếu|giờ chiếu/i', $question)) {
                preg_match('/phim\s+([^\?\.]+)/i', $question, $matches);
                if (!empty($matches[1])) {
                    $movieName = trim($matches[1]);
                    $movie = QuanLyPhim::where('ten_phim', 'like', '%' . $movieName . '%')
                            ->where('tinh_trang', 1)
                            ->first();

                    if ($movie) {
                        $showtime = SuatChieu::where('phim_id', $movie->id)
                                ->where('ngay_chieu', '>=', now()->format('Y-m-d'))
                                ->orderBy('ngay_chieu', 'asc')
                                ->orderBy('gio_bat_dau', 'asc')
                                ->first();

                        if ($showtime) {
                            $totalSeats = 48;
                            $bookedSeats = ChiTietVe::where('id_suat', $showtime->id)
                                        ->where('tinh_trang', 1)
                                        ->count();
                            $availableSeats = max(0, $totalSeats - $bookedSeats);

                            $contextData['movie'] = $movie;
                            $contextData['showtime'] = $showtime;
                            $contextData['availableSeats'] = $availableSeats;
                        }
                    }
                }
            }

            // Get additional context data
            $additionalContext = $this->getContextData($question);
            $contextData = array_merge($contextData, $additionalContext);

            // Call Gemini API with enhanced context
            $response = $this->callGeminiApi($question, $contextData);

            return response()->json([
                'status' => true,
                'message' => $response
            ]);

        } catch (Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());

            // Even error messages go through Gemini for natural language response
            $errorContext = [
                'error' => $e->getMessage(),
                'type' => 'error_response'
            ];
            $errorResponse = $this->callGeminiApi(
                "Đã xảy ra lỗi trong quá trình xử lý. Hãy thông báo cho người dùng một cách thân thiện.",
                $errorContext
            );

            return response()->json([
                'status' => false,
                'message' => $errorResponse,
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
            'danh_gia' => [],
            'dich_vu' => [],
            'hoa_don' => []
        ];

        // Check for bill total and spending related keywords
        if (preg_match('/(tổng tiền|chi tiêu|đã tiêu|số tiền|thanh toán|đã xài|đã dùng|tổng cộng|tổng số tiền|tổng chi phí)/ui', $question)) {
            // Extract customer ID if mentioned in conversation context
            if (preg_match('/khách hàng (\d+)|user (\d+)|id (\d+)/i', $question, $matches)) {
                $customerId = $matches[1] ?? $matches[2] ?? $matches[3];
            } else {
                // Try to get from request context if available
                $customerId = request()->input('userId');
            }

            if ($customerId) {
                // Get all paid bills for the customer
                $hoaDons = HoaDon::where('id_khach_hang', $customerId)
                    ->where('trang_thai', 1) // Only count paid bills
                    ->get();

                if ($hoaDons->isNotEmpty()) {
                    // Calculate total spending
                    $tongChiTieu = $hoaDons->sum('tong_tien');

                    // Get spending statistics
                    $thongKe = [
                        'tong_chi_tieu' => $tongChiTieu,
                        'so_hoa_don' => $hoaDons->count(),
                        'hoa_don_gan_nhat' => $hoaDons->sortByDesc('created_at')->first(),
                        'chi_tieu_trung_binh' => $tongChiTieu / $hoaDons->count(),
                    ];

                    // Get recent transactions
                    $giaoDichGanNhat = HoaDon::with(['suatChieu.phim', 'chiTietVes'])
                        ->where('id_khach_hang', $customerId)
                        ->where('trang_thai', 1)
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();

                    $contextData['query_type'] = 'spending_summary';
                    $contextData['thong_ke'] = $thongKe;
                    $contextData['giao_dich_gan_nhat'] = $giaoDichGanNhat;
                    $contextData['customer_id'] = $customerId;
                }
            }
        }

        // Check for specific bill queries
        if (preg_match('/(hoá đơn|hóa đơn|bill|biên lai|phiếu thu|receipt)/ui', $question)) {
            $customerId = request()->input('userId');

            if ($customerId) {
                if (preg_match('/(gần đây|last|latest|mới nhất)/ui', $question)) {
                    // Get most recent bill
                    $hoaDon = HoaDon::with(['suatChieu.phim', 'chiTietVes'])
                        ->where('id_khach_hang', $customerId)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($hoaDon) {
                        $contextData['query_type'] = 'latest_bill';
                        $contextData['hoa_don'] = $hoaDon;
                    }
                } else if (preg_match('/mã\s*(?:hóa đơn|hoá đơn)?\s*[:#]?\s*([A-Z0-9]+)/ui', $question, $matches)) {
                    // Get specific bill by code
                    $maHoaDon = $matches[1];
                    $hoaDon = HoaDon::with(['suatChieu.phim', 'chiTietVes'])
                        ->where('ma_hoa_don', $maHoaDon)
                        ->where('id_khach_hang', $customerId)
                        ->first();

                    if ($hoaDon) {
                        $contextData['query_type'] = 'specific_bill';
                        $contextData['hoa_don'] = $hoaDon;
                    }
                }
            }
        }

        // Check for genre-related keywords
        if (preg_match('/(thể loại|loại phim|genre|kiểu phim|phim gì|phim kiểu|dạng phim|phim dạng|phim thuộc)/ui', $question)) {
            // Get all genres
            $theLoai = TheLoai::all();

            if (preg_match('/phim\s+([^?\.]+?)(?:\s+thuộc|có|là|thể loại|loại gì|dạng gì|\?|$)/ui', $question, $matches)) {
                // If asking about a specific movie's genre
                $movieName = trim($matches[1]);
                $movie = QuanLyPhim::where('ten_phim', 'like', '%' . $movieName . '%')
                        ->orWhere('slug_phim', 'like', '%' . strtolower(str_replace(' ', '-', $movieName)) . '%')
                        ->first();

                if ($movie) {
                    // Get genres for this specific movie
                    $movieGenres = TheLoai::join('chi_tiet_the_loais', 'the_loais.id', '=', 'chi_tiet_the_loais.id_the_loai')
                        ->where('chi_tiet_the_loais.id_phim', $movie->id)
                        ->select('the_loais.*', 'chi_tiet_the_loais.mo_ta as chi_tiet_mo_ta')
                        ->get();

                    $contextData['query_type'] = 'movie_genre';
                    $contextData['movie'] = $movie;
                    $contextData['movie_genres'] = $movieGenres;
                }
            } else {
                // Check if asking about movies of a specific genre
                foreach ($theLoai as $genre) {
                    if (preg_match('/\b' . preg_quote($genre->ten_the_loai, '/') . '\b/ui', $question)) {
                        // Get movies of this genre
                        $moviesInGenre = QuanLyPhim::join('chi_tiet_the_loais', 'quan_ly_phims.id', '=', 'chi_tiet_the_loais.id_phim')
                            ->join('the_loais', 'the_loais.id', '=', 'chi_tiet_the_loais.id_the_loai')
                            ->where('the_loais.id', $genre->id)
                            ->where('quan_ly_phims.tinh_trang', 1)
                            ->select('quan_ly_phims.*')
                            ->distinct()
                            ->take(5)
                            ->get();

                        $contextData['query_type'] = 'genre_movies';
                        $contextData['genre'] = $genre;
                        $contextData['movies_in_genre'] = $moviesInGenre;
                        break;
                    }
                }
            }

            // If no specific genre or movie was found, return all genres
            if (!isset($contextData['query_type'])) {
                $contextData['query_type'] = 'all_genres';
                $contextData['all_genres'] = $theLoai;

                // Get a count of movies for each genre
                $genreCounts = [];
                foreach ($theLoai as $genre) {
                    $count = ChiTietTheLoai::join('quan_ly_phims', 'quan_ly_phims.id', '=', 'chi_tiet_the_loais.id_phim')
                        ->where('chi_tiet_the_loais.id_the_loai', $genre->id)
                        ->where('quan_ly_phims.tinh_trang', 1)
                        ->distinct('quan_ly_phims.id')
                        ->count();
                    $genreCounts[$genre->id] = $count;
                }
                $contextData['genre_counts'] = $genreCounts;
            }
        }

        // Also check for genre keywords without explicit "thể loại" mention
        foreach (TheLoai::all() as $genre) {
            if (preg_match('/\b' . preg_quote($genre->ten_the_loai, '/') . '\b/ui', $question)) {
                // Get movies of this genre
                $moviesInGenre = QuanLyPhim::join('chi_tiet_the_loais', 'quan_ly_phims.id', '=', 'chi_tiet_the_loais.id_phim')
                    ->join('the_loais', 'the_loais.id', '=', 'chi_tiet_the_loais.id_the_loai')
                    ->where('the_loais.id', $genre->id)
                    ->where('quan_ly_phims.tinh_trang', 1)
                    ->select('quan_ly_phims.*')
                    ->distinct()
                    ->take(5)
                    ->get();

                $contextData['query_type'] = 'genre_movies';
                $contextData['genre'] = $genre;
                $contextData['movies_in_genre'] = $moviesInGenre;
                break;
            }
        }

        // Check for service-related keywords
        if (preg_match('/(dịch vụ|đồ ăn|nước uống|bắp|nước|combo|popcorn|thức ăn|đồ uống|snack|food|drink)/ui', $question)) {
            $dichVu = DichVu::where('tinh_trang', 1)->get();
            if ($dichVu->isNotEmpty()) {
                // Group services by type for better response formatting
                $groupedServices = [
                    'do_an' => [],
                    'do_uong' => [],
                    'combo' => []
                ];

                foreach ($dichVu as $dv) {
                    // Categorize services based on name
                    if (preg_match('/(combo|set)/ui', $dv->ten_dich_vu)) {
                        $groupedServices['combo'][] = $dv;
                    } elseif (preg_match('/(nước|pepsi|coca|sprite|drink)/ui', $dv->ten_dich_vu)) {
                        $groupedServices['do_uong'][] = $dv;
                    } else {
                        $groupedServices['do_an'][] = $dv;
                    }
                }

                $contextData['dich_vu'] = [
                    'all' => $dichVu,
                    'grouped' => $groupedServices
                ];

                // Add specific context based on user's question
                if (preg_match('/(giá|price|cost|bao nhiêu tiền)/ui', $question)) {
                    $contextData['query_type'] = 'price_check';
                } elseif (preg_match('/(combo|set)/ui', $question)) {
                    $contextData['query_type'] = 'combo_check';
                } elseif (preg_match('/(đồ ăn|thức ăn|food|bắp)/ui', $question)) {
                    $contextData['query_type'] = 'food_check';
                } elseif (preg_match('/(nước|drink|đồ uống)/ui', $question)) {
                    $contextData['query_type'] = 'drink_check';
                }
            }
        }

        // Extract data based on question keywords
        if (str_contains(strtolower($question), 'phim') ||
            str_contains(strtolower($question), 'movie')) {
            $contextData['phim'] = QuanLyPhim::take(10)->get()->toArray();

            // If the question is about movie recommendations, include genre information
            if (preg_match('/(gợi ý|đề xuất|recommend|suggestion|like|similar|giống|tương tự)/ui', $question)) {
                // Get genres of recently watched or mentioned movies
                $recentMovieGenres = ChiTietTheLoai::whereIn('id_phim', array_column($contextData['phim'], 'id'))
                    ->join('the_loais', 'the_loais.id', '=', 'chi_tiet_the_loais.id_the_loai')
                    ->select('the_loais.*')
                    ->distinct()
                    ->get();
                $contextData['recent_genres'] = $recentMovieGenres;
            }
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

        return array_filter($contextData, function($value) {
            return !empty($value);
        });
    }

    private function callGeminiApi($question, $contextData)
    {
        // Define chatbot personality and context
        $personality = "Tôi là Mia - trợ lý ảo vui vẻ và thân thiện của rạp chiếu phim. " .
                      "Tôi luôn trả lời ngắn gọn, dễ hiểu và có chút hài hước. " .
                      "Tôi thích sử dụng emoji phù hợp và giọng điệu tự nhiên khi trò chuyện.";

        // Format context data for better prompting
        $formattedContext = "";
        if (!empty($contextData)) {
            // Add spending and bill specific context formatting
            if (isset($contextData['type']) && $contextData['type'] === 'bill_history') {
                $formattedContext .= "\nDanh sách hóa đơn:\n";
                foreach ($contextData['bills'] as $bill) {
                    $formattedContext .= sprintf(
                        "* **%s (%s):** %s (%s) - %s %s\n",
                        $bill['ma_hoa_don'],
                        $bill['time'],
                        $bill['amount'],
                        $bill['payment_method'],
                        $bill['movie_name'],
                        $bill['status']
                    );
                }
            } else if (isset($contextData['query_type'])) {
                if ($contextData['query_type'] === 'spending_summary') {
                    $formattedContext .= "\nThống kê chi tiêu: " . json_encode($contextData['thong_ke'], JSON_UNESCAPED_UNICODE);
                    $formattedContext .= "\nGiao dịch gần đây: " . json_encode($contextData['giao_dich_gan_nhat'], JSON_UNESCAPED_UNICODE);
                } else if (in_array($contextData['query_type'], ['latest_bill', 'specific_bill'])) {
                    $formattedContext .= "\nThông tin hóa đơn: " . json_encode($contextData['hoa_don'], JSON_UNESCAPED_UNICODE);
                }
            }

            // Add genre-specific context formatting
            if (isset($contextData['query_type']) && strpos($contextData['query_type'], 'genre') !== false) {
                $formattedContext .= "\nLoại câu hỏi về thể loại: " . $contextData['query_type'];

                if (isset($contextData['genre'])) {
                    $formattedContext .= "\nThể loại: " . json_encode($contextData['genre'], JSON_UNESCAPED_UNICODE);
                }
                if (isset($contextData['movie_genres'])) {
                    $formattedContext .= "\nThể loại của phim: " . json_encode($contextData['movie_genres'], JSON_UNESCAPED_UNICODE);
                }
                if (isset($contextData['movies_in_genre'])) {
                    $formattedContext .= "\nPhim thuộc thể loại: " . json_encode($contextData['movies_in_genre'], JSON_UNESCAPED_UNICODE);
                }
                if (isset($contextData['all_genres'])) {
                    $formattedContext .= "\nTất cả thể loại: " . json_encode($contextData['all_genres'], JSON_UNESCAPED_UNICODE);
                }
                if (isset($contextData['genre_counts'])) {
                    $formattedContext .= "\nSố lượng phim mỗi thể loại: " . json_encode($contextData['genre_counts'], JSON_UNESCAPED_UNICODE);
                }
            }

            if (isset($contextData['movie'])) {
                $formattedContext .= "\nThông tin phim: " . json_encode($contextData['movie'], JSON_UNESCAPED_UNICODE);
            }
            if (isset($contextData['showtime'])) {
                $formattedContext .= "\nSuất chiếu: " . json_encode($contextData['showtime'], JSON_UNESCAPED_UNICODE);
            }
            if (isset($contextData['availableSeats'])) {
                $formattedContext .= "\nSố ghế trống: " . $contextData['availableSeats'];
            }
            if (isset($contextData['reviews'])) {
                $formattedContext .= "\nĐánh giá phim: " . json_encode($contextData['reviews'], JSON_UNESCAPED_UNICODE);
            }
            if (isset($contextData['dich_vu'])) {
                $formattedContext .= "\nDịch vụ: " . json_encode($contextData['dich_vu'], JSON_UNESCAPED_UNICODE);
                if (isset($contextData['query_type'])) {
                    $formattedContext .= "\nLoại câu hỏi về dịch vụ: " . $contextData['query_type'];
                }
            }
            foreach ($contextData as $key => $value) {
                if (!in_array($key, ['movie', 'showtime', 'availableSeats', 'reviews', 'dich_vu', 'type', 'bills']) && !empty($value)) {
                    $formattedContext .= "\n" . ucfirst($key) . ": " . json_encode($value, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        $prompt = "{$personality}\n\n" .
                 "Câu hỏi của khách hàng: \"{$question}\"\n\n" .
                 "Thông tin từ hệ thống:{$formattedContext}\n\n" .
                 "Yêu cầu khi trả lời:\n" .
                 "1. Trả lời ngắn gọn, tối đa 2-3 câu\n" .
                 "2. Sử dụng ngôn ngữ tự nhiên, thân thiện\n" .
                 "3. Thêm emoji phù hợp\n" .
                 "4. Nếu không có đủ thông tin, gợi ý các chủ đề liên quan\n" .
                 "5. Nếu có link phim, giữ nguyên thẻ HTML <a>\n" .
                 "6. Với suất chiếu, luôn hiển thị giờ và ngày theo định dạng HH:mm dd/MM/yyyy\n" .
                 "7. Với số tiền, format theo định dạng việt nam (VD: 100.000 VNĐ)\n" .
                 "8. Với dịch vụ, nhóm theo loại (đồ ăn, đồ uống, combo) và hiển thị giá\n" .
                 "9. Với thể loại, liệt kê theo dạng danh sách và thêm số lượng phim nếu có\n" .
                 "10. Với chi tiêu, hiển thị tổng tiền và chi tiết giao dịch gần đây nếu có\n" .
                 "11. Với hóa đơn, giữ nguyên định dạng markdown và emoji";

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
                "temperature" => 0.8,
                "maxOutputTokens" => 500,
                "topP" => 0.9,
                "topK" => 40
            ]
        ];

        $url = $this->geminiUrl . '?key=' . $this->apiKey;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    return $responseData['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            // If API call fails, return a friendly error message through Gemini
            return $this->callGeminiApi(
                "Hệ thống đang gặp vấn đề kỹ thuật. Hãy thông báo cho người dùng một cách thân thiện.",
                ['type' => 'technical_error']
            );
        } catch (Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return "Xin lỗi bạn! 😅 Tôi đang gặp chút vấn đề kỹ thuật. Bạn vui lòng thử lại sau hoặc liên hệ nhân viên hỗ trợ nhé!";
        }
    }

    /**
     * Suggest movies to the user matching the frontend expectations
     */
    public function suggestMovies(Request $request)
    {
        try {
            $userId = $request->query('userId', 'guest');

            $phimDangChieu = QuanLyPhim::where('tinh_trang', 1)
                            ->take(5)
                            ->get();

            $contextData = [
                'type' => 'movie_suggestions',
                'movies' => $phimDangChieu
            ];

            $response = $this->callGeminiApi(
                "Gợi ý một số phim đang chiếu cho khách hàng, kèm theo link chi tiết phim.",
                $contextData
            );

            return response()->json([
                'status' => true,
                'message' => $response,
                'data' => $phimDangChieu
            ]);
        } catch (Exception $e) {
            Log::error('Movie suggestion error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $this->callGeminiApi(
                    "Không thể lấy được danh sách phim gợi ý. Hãy thông báo cho người dùng một cách thân thiện.",
                    ['type' => 'suggestion_error']
                ),
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

    /**
     * Xem lịch sử hóa đơn của khách hàng
     */
    public function viewBillHistory(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'userId' => 'required|string',
            ]);

            $userId = $validatedData['userId'];

            $hoaDons = HoaDon::with(['suatChieu.phim', 'chiTietVes'])
                            ->where('id_khach_hang', $userId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

            // Format bill data for better display
            $formattedBills = $hoaDons->map(function ($hoaDon) {
                $status = $hoaDon->trang_thai == 1 ? '✅' : '⏳';
                $paymentMethod = $hoaDon->phuong_thuc_thanh_toan ?? 'Chưa thanh toán';
                $movieName = $hoaDon->suatChieu->phim->ten_phim ?? 'N/A';
                $amount = number_format($hoaDon->tong_tien, 0, ',', '.') . ' VNĐ';
                $time = date('H:i d/m/Y', strtotime($hoaDon->created_at));

                return [
                    'ma_hoa_don' => $hoaDon->ma_hoa_don,
                    'time' => $time,
                    'amount' => $amount,
                    'payment_method' => $paymentMethod,
                    'movie_name' => $movieName,
                    'status' => $status
                ];
            });

            $contextData = [
                'type' => 'bill_history',
                'bills' => $formattedBills
            ];

            // Create a more structured prompt for Gemini
            $prompt = "Hiển thị lịch sử 5 hóa đơn gần đây của khách hàng theo format sau:\n" .
                     "- Mã hóa đơn (Thời gian): Số tiền (Phương thức) - Tên phim Status";

            $response = $this->callGeminiApi($prompt, $contextData);

            return response()->json([
                'status' => true,
                'message' => $response,
                'data' => $formattedBills
            ]);

        } catch (Exception $e) {
            Log::error('View bill history error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $this->callGeminiApi(
                    "Không thể truy xuất lịch sử hóa đơn. Hãy thông báo cho người dùng một cách thân thiện.",
                    ['type' => 'bill_history_error']
                ),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
