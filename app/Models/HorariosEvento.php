<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorariosEvento extends Model
{
    use HasFactory;

    protected $fillable = ['evento_id', 'hora_inicio_evento'];

    /**
     * Get the evento that owns the HorariosEvento.
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}