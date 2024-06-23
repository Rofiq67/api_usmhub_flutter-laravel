<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $table = 'feeds';

    protected $fillable = [
        'kategori',
        'judul',
        'deskripsi',
        'doc_feed',
        'img_banner',
        'status',
        // 'created_at'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
