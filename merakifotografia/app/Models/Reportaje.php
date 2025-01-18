<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favorito;

class Reportaje extends Model
{
    use HasFactory;

    protected $table = 'reportajes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'foto',
        'fecha',
        'user_id',
        'categoria_id',
    ];

    public function favoritos() {
        return $this->hasMany(Favorito::class);
    }
}
