<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members'; // eksplisit biar jelas
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    protected $casts = [
        'email' => 'string',
        'phone' => 'string',
    ];

    /**
     * Relasi ke User (setiap Member punya 1 akun user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Peminjaman (1 member bisa banyak peminjaman)
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Accessor: otomatis kapitalisasi nama saat diambil
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Mutator: otomatis simpan nama dalam format lowercase di DB
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
