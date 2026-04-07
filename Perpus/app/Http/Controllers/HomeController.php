<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Book::query();
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        $books = $query->withCount('borrowings as borrow_count')->paginate(12);

        $userBorrowCount = Auth::check() ? Auth::user()->activeBorrowings()->count() : 0;

        return view('welcome', compact('books', 'userBorrowCount'));
    }

    public function dashboard()
    {
        $borrowings = \App\Models\Borrowing::where('user_id', auth()->id())->with('book')->latest()->get();

        return view('dashboard', compact('borrowings'));
    }
}
