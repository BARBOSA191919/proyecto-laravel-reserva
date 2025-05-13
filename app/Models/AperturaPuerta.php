<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AperturaPuerta extends Model
{
    use HasFactory;

    protected $fillable = ['evento_id', 'hora_apertura'];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}