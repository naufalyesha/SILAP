<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        // Cek apakah user sudah pernah memberikan review untuk lapangan ini
        $existingReview = Review::where('lapangan_id', $request->lapangan_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah pernah mengirimkan ulasan anda.'
            ], 400);
        }

        try {
            Review::create([
                'lapangan_id' => $request->lapangan_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Ulasan telah terkirim!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim ulasan.'
            ], 500);
        }
    }
}
