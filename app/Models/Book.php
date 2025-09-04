<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'published_year',
        'total_copies',
        'available_copies',
    ];

    protected $casts = [
        'published_year'   => 'integer',
        'total_copies'     => 'integer',
        'available_copies' => 'integer',
    ];

    /**
     * Relasi: 1 buku bisa punya banyak peminjaman
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Accessor: kapitalisasi judul saat ditampilkan
     */
    public function getTitleAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Mutator: simpan judul lowercase di DB
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    /**
     * Accessor: kapitalisasi nama author
     */
    public function getAuthorAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Mutator: simpan author lowercase
     */
    public function setAuthorAttribute($value)
    {
        $this->attributes['author'] = strtolower($value);
    }

    /**
     * Helper: cek apakah buku masih tersedia untuk dipinjam
     */
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    /**
     * Event: sinkronisasi available_copies dengan total_copies
     */
    protected static function booted()
    {
        static::saving(function ($book) {
            // Jika buku baru dibuat
            if (!$book->exists) {
                $book->available_copies = $book->total_copies;
            } 
            // Jika total_copies berubah, sesuaikan available_copies
            elseif ($book->isDirty('total_copies')) {
                $selisih = $book->total_copies - $book->getOriginal('total_copies');
                $book->available_copies = max(0, $book->available_copies + $selisih);
            }
        });
    }
}
