<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aduan extends Model
{
    use HasFactory;

    protected $table = 'aduans';


    protected $fillable = [
        'user_id',
        'jenis_pengaduan',
        'program_studi',
        'keterangan',
        'rating',
        'bukti_photo',
        'status',
        'is_anonymous'
    ];

    // Atribut yang harus disembunyikan dalam JSON
    protected $hidden = [
        // 'created_at',
        // 'updated_at',
    ];

    // Atribut yang dikasting (casted) ke tipe data tertentu
    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function komen(): HasMany
    {
        return $this->hasMany(Komentar::class);
    }
}
