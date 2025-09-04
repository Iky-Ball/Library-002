<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

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
        'borrowed_at' => 'datetime',
        'due_date'    => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Relasi ke Book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relasi ke Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Relasi ke User (pustakawan/admin yang approve)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Status constants
     */
    public const STATUS_REQUESTED = 'requested';
    public const STATUS_APPROVED  = 'approved';
    public const STATUS_RETURNED  = 'returned';
    public const STATUS_REJECTED  = 'rejected';

    /**
     * Helper untuk cek status
     */
    public function isRequested(): bool
    {
        return $this->status === self::STATUS_REQUESTED;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isReturned(): bool
    {
        return $this->status === self::STATUS_RETURNED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
