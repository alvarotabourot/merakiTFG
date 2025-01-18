<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';

    protected $fillable = [
        'url',
        'reportaje_id'
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }
}
