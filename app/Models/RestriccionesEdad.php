<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestriccionesEdad extends Model
{
    use HasFactory;

    protected $fillable = ['evento_id', 'edad_minima'];

    /**
     * Get the evento that owns the RestriccionesEdad.
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}