<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public $timestamps = true;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
