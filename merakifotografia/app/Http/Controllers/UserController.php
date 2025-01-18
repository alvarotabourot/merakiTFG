<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public static function getUsers(){
        $users = User::where('id', '!=', auth()->id())->get();

        return $users;
    }

    public function deleteUser($user){
        $user = User::find($user);
        if($user->foto){
            if($user->foto != 'defaultProfile.jpg'){
                $previousFoto = public_path('imagenes/fotosUsuarios') . '/' . $user->foto;
                if (file_exists($previousFoto)) {
                    unlink($previousFoto); // Elimina el archivo de la foto
                }
            }
        }

        $reportajes = ReportajeController::getReportajesByUser($user->id);

        foreach ($reportajes as $reportaje) {

            ReportajeController::deleteReportaje($reportaje);
        }

        $user->delete();

        return redirect()->route('paneldeadministrador');
    }

}
