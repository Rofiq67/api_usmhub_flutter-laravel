<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class   Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';


    protected $fillable = [
        'aduan_id',
        'user_id',
        'text',
        'file',
    ];

    public function aduan(): BelongsTo
    {
        return $this->belongsTo(Aduan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
