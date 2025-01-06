<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Peminjaman;

class Book extends Model
{
    use HasFactory;

    
    protected $fillable = ['title', 'author', 'year', 'cover'];

    // Relasi dengan tabel peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
