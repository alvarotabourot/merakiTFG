<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Http\Controllers\ReportajeController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoFotografo;
use App\Models\Reportaje;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function show($profile_id): Response
    {
        $profile = User::find($profile_id);

        if($profile->user_id = 2){
            $profile->reportajes = ReportajeController::getReportajesByUser($profile_id);
        }

        return Inertia::render('Profile/Show', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // Obtener el usuario actual
        $user = $request->user();

        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'usuario' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

        ]);

        // Procesar la foto si se proporciona una nueva
        if($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',
            ]);
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosUsuarios'), $fotoName);

            // Eliminar la foto anterior si no es la foto por defecto
            if($user->foto != 'defaultProfile.png' && file_exists(public_path('imagenes/fotosUsuarios') . '/' . $user->foto)) {
                unlink(public_path('imagenes/fotosUsuarios') . '/' . $user->foto);
            }
        } else {
            $fotoName = $user->foto; // Conservar la foto existente
        }

        // Actualizar los datos del usuario
        $user->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'descripcion' => $request->descripcion ?? '',
            'usuario' => $request->usuario,
            'rol_id' => $request->rol,
            'foto' => $fotoName,
        ]);

        // Redireccionar de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $reportajes = ReportajeController::getReportajesByUser($user->id);

        foreach ($reportajes as $reportaje) {

            ReportajeController::deleteReportaje($reportaje);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'photographer_email' => 'required|email',
        ]);

        $details = $request->only('name', 'email', 'message', 'photographer_email');

        Mail::to($details['photographer_email'])->send(new ContactoFotografo($details));
        return back();
    }
}
