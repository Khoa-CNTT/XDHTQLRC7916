<?php

namespace App\Http\Middleware;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckChucNang
{
    public function handle(Request $request, Closure $next): Response
    {
        $user   =   Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            return $next($request);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', 72)
                ->first();
            if ($check) {
                return $next($request);
            } else {
                return response()->json([
                    'status'    =>  false,
                    'message'   => 'Bạn không có quyền này',
                ]);
            }
        }
    }
}
