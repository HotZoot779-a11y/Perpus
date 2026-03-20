<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Book::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }
        $books = $query->paginate(12);

        return view('welcome', compact('books'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $booksCount = \App\Models\Book::count();
            $activeBorrowings = \App\Models\Borrowing::whereIn('status', ['pending', 'dipinjam'])->count();
            return view('admin.dashboard', compact('booksCount', 'activeBorrowings'));
        }

        $borrowings = \App\Models\Borrowing::where('user_id', $user->id)->with('book')->get();
        return view('dashboard', compact('borrowings'));
    }
}
