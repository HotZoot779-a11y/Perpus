<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->paginate(10);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Mark a borrowed book as returned.
     */
    public function returnBook(Borrowing $borrowing)
    {
$borrowing->book->increment('stock');
        $borrowing->delete();

        return back()->with('success', 'Status peminjaman berhasil diubah menjadi dikembalikan.');
    }
}
