<?php

namespace App\Models;

use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use SoftDeletes; // Mengaktifkan fitur soft deletes

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'content',
        'category_id',
        'user_id', // Pastikan user_id ada di fillable untuk mass assignment
        'upload_time',
        'gallery',
    ];

    // Cast agar kolom tertentu diperlakukan sebagai tanggal
    protected $dates = ['deleted_at', 'upload_time'];

    // Set otomatis slug saat nama diubah
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Relasi ke kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke user (author)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mengisi user_id secara otomatis saat model dibuat
    protected static function booted()
    {
        static::creating(function ($news) {
            // Jika user_id tidak diatur, isi dengan ID pengguna yang login
            if (!$news->user_id) {
                $news->user_id = Filament::auth()->user()->id;
            }
        });
    }
    protected $casts = [
        'gallery' => 'array', // Pastikan kolom gallery di-cast ke array
    ];
}
