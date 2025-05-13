<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'imagen',
        'lugar',
        'ciudad',
        'fecha',
        'categoria_id',
        'precio', 
    ];

    public function horariosEvento(): HasOne
    {
        return $this->hasOne(HorariosEvento::class);
    }

    public function aperturaPuerta(): HasOne
    {
        return $this->hasOne(AperturaPuerta::class);
    }

    public function restriccionesEdad(): HasOne
    {
        return $this->hasOne(RestriccionesEdad::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}