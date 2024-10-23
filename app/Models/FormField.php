<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormField extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'name',
        'type',
        'required',
        'category',
        'options',
    ];

    protected $casts = [
        'required' => 'boolean',
        'options' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
