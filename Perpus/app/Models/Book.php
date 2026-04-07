<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publisher', 'year', 'stock', 'cover_image', 'description', 'genre', 'pdf_file'];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function activeBorrowings()
    {
        return $this->hasMany(Borrowing::class)->where('status', 'borrowed');
    }

    public function getActiveBorrowCountAttribute()
    {
        return $this->borrowings()->count();
    }
}
