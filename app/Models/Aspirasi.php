<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasis';

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'jenis_aspirasi',
        'program_studi',
        'keterangan',
        'rating',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Atribut yang dikasting (casted) ke tipe data tertentu
    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
