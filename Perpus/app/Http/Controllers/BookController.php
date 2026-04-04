<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = \App\Models\Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|length:4',
            'stock' => 'required|string|min:0|length:2',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'required|mimes:pdf|max:20480'
        ]);

        $data = $request->except(['cover_image', 'pdf_file']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        \App\Models\Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(\App\Models\Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(\App\Models\Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, \App\Models\Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|string|length:4',
            'stock' => 'required|string|min:0|length:2',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:20480'
        ]);

        $data = $request->except(['cover_image', 'pdf_file']);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(\App\Models\Book $book)
    {
        if ($book->cover_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function read(\App\Models\Book $book)
    {
        if (!$book->pdf_file) {
            return redirect()->back()->with('error', 'Buku ini belum memiliki file E-Book.');
        }
        return view('books.read', compact('book'));
    }
}
