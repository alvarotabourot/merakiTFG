<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function createFotografo(): Response
    {
        return Inertia::render('Auth/RegisterFotografo');
    }



    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'foto' => 'nullable|mimes:jpeg,png,gif,webp,svg,bmp,tiff,ico|max:5000',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Procesamiento de la imagen de perfil (si se proporciona)
        if($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->extension();
            $foto->move(public_path('imagenes/fotosUsuarios'), $fotoName);
        } else {
            $fotoName = 'defaultProfile.jpg';
        }

        // Creación del usuario en la base de datos
        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'usuario' => $request->usuario,
            'foto' => $fotoName,
            'descripcion' => $request->descripcion,
            'rol_id' => $request->rol,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('welcome', absolute: false));
    }
}
