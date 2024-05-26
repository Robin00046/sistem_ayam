<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendapatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kandang',
        'jumlah',
        'harga',
        'total'
    ];

    public function kandang()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('F Y');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'ASC');
    }

    public function scopeTotal($query)
    {
        return $query->sum('jumlah');
    }
}
