<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function store(Request $request, \App\Models\Book $book)
    {
        if ($book->stock <= 0) {
            return back()->with('error', 'Buku sedang tidak tersedia (stok habis).');
        }

        $activeBorrowing = \App\Models\Borrowing::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->first();

        if ($activeBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        \App\Models\Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'status' => 'pending'
        ]);

        $book->decrement('stock');

        return redirect()->route('dashboard')->with('success', 'Permintaan peminjaman berhasil dibuat.');
    }

    public function index()
    {
        $borrowings = \App\Models\Borrowing::with(['user', 'book'])->latest()->paginate(10);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function update(Request $request, \App\Models\Borrowing $borrowing)
    {
        $request->validate([
            'status' => 'required|in:pending,dipinjam,kembali'
        ]);

        // If returned, increment book stock
        if ($request->status === 'kembali' && $borrowing->status !== 'kembali') {
            $borrowing->book->increment('stock');
        }

        // If changed back from kembali (edge case), decrement stock
        if ($borrowing->status === 'kembali' && $request->status !== 'kembali') {
            $borrowing->book->decrement('stock');
        }

        $borrowing->update(['status' => $request->status]);

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function destroy(\App\Models\Borrowing $borrowing)
    {
        // If deleted before returned, increment the book stock
        if ($borrowing->status !== 'kembali') {
            $borrowing->book->increment('stock');
        }

        $borrowing->delete();

        return back()->with('success', 'Histori peminjaman berhasil dihapus.');
    }
}
