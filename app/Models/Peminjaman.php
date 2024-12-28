<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Book;
class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';

    protected $fillable = ['book_id', 'borrower_name', 'borrow_date', 'return_date'];

    // Relasi dengan tabel buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
