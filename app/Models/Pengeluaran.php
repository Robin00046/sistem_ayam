<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;


    protected $fillable = [
        'kandang_id',
        'jenis_produk_id',
        'jumlah',
        'total'
    ];

    public function kandang()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisProduk()
    {
        return $this->belongsTo(JenisProduk::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F Y');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
