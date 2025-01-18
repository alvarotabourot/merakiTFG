<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;

class FotoController extends Controller
{
    /**
     * Crea un nuevo archivo asociado a un reportaje.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public static function createFoto(Request $request)
    {   // Validación de los datos de entrada
        $request->validate([
            'url' => 'required|string|max:255',
            'reportaje_id' => 'required|integer',
        ]);

        $foto = new Foto;
        $foto->url = $request->url;
        $foto->reportaje_id = $request->reportaje_id;
        $foto->save();
    }

    /**
     * Elimina un archivo existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function deleteFoto(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'id' => 'required|integer',
        ]);

        $foto = Foto::find($request->id);
        if ($foto) {
            $foto->delete();
        }
    }
}
