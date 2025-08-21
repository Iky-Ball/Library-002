<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Peminjaman extends Model
{
    use HasFactory;


    protected $fillable = [
        'book_id',
        'member_id',
        'status',
        'borrowed_at',
        'due_date',
        'returned_at',
        'approved_by',
        'notes'
    ];


    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }


    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}