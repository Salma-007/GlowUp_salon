<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('rating', 'desc')
                         ->orderBy('created_at', 'desc') 
                         ->take(3) 
                         ->get();

        return view('home', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('home')->with('success', 'Avis supprimé avec succès !');
    }
}
