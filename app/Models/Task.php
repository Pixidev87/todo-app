<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_completed'
    ];

    // kapcsolat a feladat és a felhasználó között
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
