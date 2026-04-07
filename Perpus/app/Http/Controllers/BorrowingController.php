<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Borrow a book.
     */
    public function store(Request $request, Book $book)
    {
        $user = Auth::user();

        // Max 2 active books
        if ($user->activeBorrowings()->count() >= 2) {
            return back()->with('error', 'Anda sudah meminjam maksimal 2 buku aktif.');
        }

        // Check stock
        $stock = (int) $book->stock;
        if ($stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        // Check if the book is already borrowed by the user and not returned
        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        $book->decrement('stock');

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        return redirect()->route('dashboard')->with('success', 'Buku berhasil dipinjam.');
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(Borrowing $borrowing)
    {
        // Ensure the borrowing belongs to the current user
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

$borrowing->book->increment('stock');
        $borrowing->delete();

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
