<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryForward extends Model
{
    use HasFactory;

    protected $table = 'aduan_forward_histories';

    protected $fillable = [
        'aduan_id',
        'from_program_studi',
        'to_program_studi',
        'user_id',
    ];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
