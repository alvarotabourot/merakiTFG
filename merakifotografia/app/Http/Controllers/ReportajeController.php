<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reportaje;
use App\Models\Categoria;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Foto;
use App\Models\User;
use App\Models\Favorito;
use Illuminate\Support\Facades\Auth;

class ReportajeController extends Controller
{

    public function showReportaje($reportaje)
    {
        $reportaje = Reportaje::find($reportaje);

        if (!$reportaje || !isset($reportaje->user_id)) {
            abort(404, 'El reportaje no existe o no tiene un usuario asociado.');
        }

        // Obtener el fotógrafo
        $reportaje->fotografo = User::find($reportaje->user_id);

        // Obtener fotos del reportaje
        $reportaje->fotos = Foto::where('reportaje_id', $reportaje->id)->get();

        // Obtener favoritos y contar total
        $reportaje->favoritos = Favorito::where('reportaje_id', $reportaje->id)->get();
        $favoritosCount = $reportaje->favoritos->count();

        // Comprobar si el usuario actual ha marcado como favorito
        $isFavorito = $reportaje->favoritos->contains('user_id', auth()->id());

        return Inertia::render('Reportajes/Reportaje', [
            'reportaje' => $reportaje,
            'categorias' => CategoriaController::getCategorias(),
            'isFavorito' => $isFavorito,
            'favoritosCount' => $favoritosCount, // Pasar el total de favoritos al componente
        ]);
    }


    public static function getReportajesMasGustados(){
        $reportajes = Reportaje::withCount('favoritos')
            ->orderBy('favoritos_count', 'desc')
            ->take(6)
            ->get();

        return $reportajes;
    }

    public static function getReportajes(){
        $reportajes = Reportaje::all();

        return $reportajes;
    }

    public static function getMisFavoritos(){
        $favoritos = Favorito::where('user_id', auth()->user()->id)->get();

        $reportajes = [];
        $categorias = Categoria::all();

        foreach ($favoritos as $favorito) {
            $reportaje = Reportaje::find($favorito->reportaje_id);
            $fotos = Foto::where('reportaje_id', $reportaje->id)
                        ->get()
                        ->toArray();

            $reportaje->fotos = $fotos;

            $user = User::find($reportaje->user_id);
            $reportaje->fotografo = $user;
            $reportajes[] = $reportaje;

        }

        return Inertia::render('Favoritos/Favoritos', [
            'reportajes' => $reportajes,
            'categorias' => $categorias,
        ]);
    }



    public static function getReportajesByUser($user_id){
        $reportajes = Reportaje::where('user_id', $user_id)->get();

        foreach ($reportajes as $reportaje) {
            // Busca los fotos asociados a cada tarea
            $fotos = Foto::where('reportaje_id', $reportaje->id)
                        ->get();

            // Asigna los fotos encontrados a la tarea actual
            $reportaje->fotos = $fotos;
        }

        return $reportajes;
    }


    public function getMisReportajes(){

        $user = Auth::user();
        $reportajes = Reportaje::where('user_id', $user->id)->get();
        $categorias = Categoria::all();

        foreach ($reportajes as $reportaje) {
            // Busca los fotos asociados a cada tarea
            $fotos = Foto::where('reportaje_id', $reportaje->id)
                        ->get()
                        ->toArray();

            // Asigna los fotos encontrados a la tarea actual
            $reportaje->fotos = $fotos;

            $user = User::find($reportaje->user_id);
            $reportaje->fotografo = $user;
        }

        return Inertia::render('Reportajes/Reportajes', [
            'reportajes' => $reportajes,
            'categorias' => $categorias,
        ]);

    }

    public function createReportaje(Request $request){

        // Validar los datos recibidos del formulario de creación de reportaje personal
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',
            'fecha' => 'required|date',
            'fotos.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,xls,xlsx,doc,docx,ppt,pptx|max:5000',
            'categoria_id' => 'required|numeric',
        ]);

        // Subir y almacenar la imagen de foto si existe
        $fotoName = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosReportajes'), $fotoName);
        }

        // Subir y almacenar los fotos adjuntos si existen
        $fotoNames = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('imagenes/fotosReportajes'), $fotoName);
                $fotoNames[] = $fotoName;
            }
        }


        // Crear una nueva reportaje personal en la base de datos
        $reportaje = Reportaje::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'foto' => $fotoName,
            'fecha' => $request->fecha,
            'user_id' => auth()->user()->id,
            'categoria_id' => $request->categoria_id,
        ]);

        // Llamar a un método para manejar la subida de fotos asociados a la eportaje creada
        $this->subirFotos($fotoNames, $reportaje->id);

        // Redirigir a la ruta de tablón después de crear la reportaje
        return $this->getMisReportajes($request);
    }


    public function updateReportaje(Request $request, Reportaje $reportaje)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
            'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',
            'fecha' => 'required|date',
            'fotos.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,xls,xlsx,doc,docx,ppt,pptx|max:5000',
        ]);

        // Subir y almacenar la imagen de portada si existe
        $fotoName = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosReportajes'), $fotoName);

            // Eliminar la imagen de portada anterior si existe
            if ($reportaje->foto) {
                $previousFoto = public_path('imagenes/fotosReportajes') . '/' . $reportaje->foto;
                if (file_exists($previousFoto)) {
                    unlink($previousFoto);
                }
            }

            // Actualiza el campo de foto en la base de datos con la nueva imagen
            $reportaje->foto = $fotoName;
        }

        // Subir y almacenar las fotos adjuntas si existen
        $fotoNames = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('imagenes/fotosReportajes'), $fotoName);
                $fotoNames[] = $fotoName;
            }
        }

        // Asegúrate de que $fotoNames siempre sea un array
        $this->subirFotos($fotoNames, $reportaje->id);

        // Eliminar los fotos seleccionados para eliminar si existen
        if ($request->has('fotosParaEliminar')) {
            foreach ($request->fotosParaEliminar as $fotoId) {
                $foto = Foto::find($fotoId);
                if ($foto) {
                    $fotoPath = public_path('imagenes/fotosReportajes') . '/' . $foto->url;
                    if (file_exists($fotoPath)) {
                        unlink($fotoPath);
                    }
                    $foto->delete();
                }
            }
        }

        // Actualizar el reportaje
        $reportaje->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'user_id' => auth()->user()->id,
            'categoria_id' => $request->categoria_id,
        ]);

        return $this->getMisReportajes($request);
    }


    public static function deleteReportaje(Reportaje $reportaje)
    {
        try {

            if ($reportaje->foto) {
                $fotoPath = public_path('imagenes/fotosReportajes') . '/' . $reportaje->foto;
                if (file_exists($fotoPath)) {
                    unlink($fotoPath); // Elimina la foto principal
                }
            }

            // Elimina las fotos asociadas del almacenamiento y la base de datos
            $fotos = Foto::where('reportaje_id', $reportaje->id)->get();
            foreach ($fotos as $foto) {
                $fotoPath = public_path('imagenes/fotosReportajes') . '/' . $foto->url;
                if (file_exists($fotoPath)) {
                    unlink($fotoPath); // Elimina el archivo de la foto
                }
                $foto->delete(); // Elimina el registro de la base de datos
            }

            // Elimina el registro del reportaje de la base de datos
            $reportaje->delete();

            if(auth()->user()->rol_id == 1){
                return redirect()->route('paneldeadministrador');
            }

            return $this->getMisReportajes()->with('status', 'Reportaje eliminado correctamente');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar el reportaje: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Error al eliminar el reportaje.']);
        }
    }


    public function subirFotos(Array $fotoNames, $reportaje_id)
    {
        // Iterar a través de los nombres de los fotos y crear registros de foto asociados a la tarea
        foreach ($fotoNames as $fotoName) {
            FotoController::createFoto(new Request([
                'url' => $fotoName,
                'reportaje_id' => $reportaje_id,
            ]));
        }
    }

    public function addFavorito($reportaje){
        $reportaje = Reportaje::find($reportaje);
        $user = auth()->user();
        $favorito = new Favorito;
        $favorito->user_id = $user->id;
        $favorito->reportaje_id = $reportaje->id;
        $favorito->save();

        return $this->showReportaje($reportaje->id);
    }

    public function deleteFavorito($reportaje){
        $reportaje = Reportaje::find($reportaje);
        $user = auth()->user();
        $favorito = Favorito::where('user_id', $user->id)->where('reportaje_id', $reportaje->id)->first();
        if($favorito){
            $favorito->delete();
        }

        return $this->showReportaje($reportaje->id);
    }
}
