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

        try {
            Review::create([
                'lapangan_id' => $request->lapangan_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            return redirect()->route('detailLapangan', $request->lapangan_id)
                ->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('detailLapangan', $request->lapangan_id)
                ->with('error', 'Failed to submit review.');
        }
    }
}
