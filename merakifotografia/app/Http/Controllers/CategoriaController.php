<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Reportaje;
use App\Models\Foto;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    public static function getCategorias(){
        $categorias = Categoria::all();

        return $categorias;
    }

    public static function getCategoriasDestacadas(){
        $categorias = Categoria::withCount('reportajes')
            ->orderBy('reportajes_count', 'desc')
            ->take(3)
            ->get();

        return $categorias;
    }

    public function indexCategorias(){
        $categorias = Categoria::all();

        return Inertia::render('Categoria/Categorias', [
            'categorias' => $categorias,
        ]);
    }

    public function showCategoria($categoria){
        $categoria = Categoria::find($categoria);

        $categorias = Categoria::all();

        $reportajes = Reportaje::where('categoria_id', $categoria->id)->get();

        foreach ($reportajes as $reportaje) {
            // Busca los fotos asociados a cada tarea
            $fotos = Foto::where('reportaje_id', $reportaje->id)
                        ->get()
                        ->toArray();

            // Asigna los fotos encontrados a la tarea actual
            $reportaje->fotos = $fotos;
        }

        return Inertia::render('Categoria/Categoria', [
            'categoria' => $categoria,
            'reportajes' => $reportajes,
            'categorias' => $categorias,
        ]);
    }

    public function createCategoria(Request $request){

        $request->validate([
            'nombre' => 'required|unique:'.Categoria::class,
            'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',

        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosCategorias'), $fotoName);
        }

        $categoria = new Categoria;
        $categoria->nombre = $request->nombre;
        $categoria->foto = $fotoName;
        $categoria->save();

        return redirect()->route('paneldeadministrador');

    }

    public function updateCategoria( Request $request, Categoria $categoria){
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id,
            'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',
        ]);

        $fotoName = $categoria->foto;
        if ($request->hasFile('foto')) {
            // Subir y guardar la nueva imagen de portada si se sube una nueva
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosCategorias'), $fotoName);

            // Eliminar la imagen de portada anterior si existe
            if ($categoria->foto) {
                $previousPortada = public_path('imagenes/fotosCategorias') . '/' . $categoria->foto;
                if (file_exists($previousPortada)) {
                    unlink($previousPortada); // Eliminar el archivo físico de la imagen anterior
                }
            }
        }

        $categoria->update([
            'nombre' => $request->nombre,
            'foto' => $fotoName,
        ]);

        return redirect()->route('paneldeadministrador');
    }

    public function deleteCategoria($categoria_id){
        $categoria = Categoria::findOrFail($categoria_id);

        if($categoria->foto){

            if($categoria->foto != 'defaultCategoria.jpg'){
                $previousFoto = public_path('imagenes/fotosCategorias') . '/' . $categoria->foto;
                if (file_exists($previousFoto)) {
                    unlink($previousFoto); // Elimina el archivo de la foto
                }
            }
        }

        $reportajes = Reportaje::where('categoria_id', $categoria->id)->get();
        $categoriaGeneral = Categoria::where('nombre', 'General')->first();

        foreach ($reportajes as $reportaje) {

            $reportaje->categoria_id = $categoriaGeneral->id;
            $reportaje->save();
        }

        $categoria->delete();

        return redirect()->route('paneldeadministrador');

    }
}
