<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ReportajeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'categorias' => CategoriaController::getCategoriasDestacadas(),
        'reportajesMasGustados' => ReportajeController::getReportajesMasGustados()


    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/PanelDeAdministrador', function () {
    return Inertia::render('Admin/PanelAdministrador',[
        'categorias' => CategoriaController::getCategorias(),
        'reportajes' => ReportajeController::getReportajes(),
        'users' => UserController::getUsers(),
        'roles' => RolesController::getRoles(),
    ]);


})->middleware(['auth', 'verified'])->name('paneldeadministrador');



Route::get('/MisReportajes', [ReportajeController::class, 'getMisReportajes'])->middleware(['auth', 'verified'])->name('mis_reportajes');

Route::get('/MisFavoritos', [ReportajeController::class, 'getMisFavoritos'])->middleware(['auth', 'verified'])->name('mis_favoritos');

Route::post('/reportaje/create', [ReportajeController::class, 'createReportaje'])->middleware(['auth', 'verified'])->name('reportaje.create');

Route::post('/reportaje/update/{reportaje}', [ReportajeController::class, 'updateReportaje'])->middleware(['auth', 'verified'])->name('reportaje.update');

Route::delete('/reportaje/delete/{reportaje}', [ReportajeController::class, 'deleteReportaje'])->middleware(['auth', 'verified'])->name('reportaje.destroy');

Route::get('/Reportaje/{reportaje}', [ReportajeController::class, 'showReportaje'])->name('reportaje.show');

Route::post('/favorito/store/{reportaje}', [ReportajeController::class, 'addFavorito'])->middleware(['auth', 'verified'])->name('favorito.store');

Route::delete('/favorito/destroy/{reportaje}', [ReportajeController::class, 'deleteFavorito'])->middleware(['auth', 'verified'])->name('favorito.destroy');

Route::get('/categorias', [CategoriaController::class, 'indexCategorias'])->name('categorias');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'showCategoria'])->name('categoria.show');

Route::post('/categoria/create', [CategoriaController::class, 'createCategoria'])->middleware(['auth', 'verified'])->name('categoria.create');

Route::post('/categoria/update/{categoria}', [CategoriaController::class, 'updateCategoria'])->middleware(['auth', 'verified'])->name('categoria.update');

Route::delete('/categoria/delete/{categoriaId}', [CAtegoriaController::class, 'deleteCategoria'])->middleware(['auth', 'verified'])->name('categoria.destroy');

Route::delete('/user/delete/{userId}', [UserController::class, 'deleteUser'])->middleware(['auth', 'verified'])->name('user.destroy');

Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.show');

Route::post('/contact-photographer', [ProfileController::class, 'sendEmail'])->name('contact.photographer');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::fallback(function () {
    return Inertia::render('Errors/404'); // Asegúrate de tener el componente Vue configurado en 'Errors/404'
});


require __DIR__.'/auth.php';
