<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
    ];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }
}
