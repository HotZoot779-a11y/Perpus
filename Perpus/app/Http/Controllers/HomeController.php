<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $books = $query->paginate(12);

        return view('welcome', compact('books'));
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.books.index');
        }

        return redirect()->route('profile.edit');
    }
}
