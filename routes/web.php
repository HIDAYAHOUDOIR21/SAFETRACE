<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\TemoignageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $total_annonces = \App\Models\Annonce::where('valide_admin', true)->count();
    $total_retrouvees = \App\Models\Annonce::where('statut', 'retrouve_vivant')->count();
    $cette_semaine = \App\Models\Annonce::where('created_at', '>=', now()->subDays(7))->count();
    return view('welcome', compact('total_annonces', 'total_retrouvees', 'cette_semaine'));
});

Route::get('/annonces', [AnnonceController::class, 'index']);
Route::get('/annonces/create', [AnnonceController::class, 'create'])->middleware('auth');
Route::post('/annonces', [AnnonceController::class, 'store'])->middleware('auth');
Route::get('/annonces/{id}', [AnnonceController::class, 'show']);
Route::get('/annonces/{id}/edit', [AnnonceController::class, 'edit'])->middleware('auth');
Route::put('/annonces/{id}', [AnnonceController::class, 'update'])->middleware('auth');
Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy'])->middleware('auth');
Route::post('/annonces/{id}/retrouve', [AnnonceController::class, 'marquerRetrouve'])->middleware('auth');
Route::get('/carte', [AnnonceController::class, 'carte']);
Route::get('/mes-annonces', [AnnonceController::class, 'dashboard'])->middleware('auth');

Route::post('/notifications/lire', [AnnonceController::class, 'marquerNotificationsLues'])->middleware('auth');

Route::get('/annonces/{annonce_id}/temoignages/create', [TemoignageController::class, 'create']);
Route::post('/annonces/{annonce_id}/temoignages', [TemoignageController::class, 'store']);
Route::delete('/annonces/{annonce_id}/temoignages/{temoignage_id}', [TemoignageController::class, 'destroy'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
Route::post('/admin/annonces/{id}/valider', [AdminController::class, 'valider'])->middleware('auth');
Route::post('/admin/annonces/{id}/refuser', [AdminController::class, 'refuser'])->middleware('auth');

Route::get('/messages', [MessageController::class, 'index'])->middleware('auth');
Route::get('/messages/create/{user_id}/{annonce_id?}', [MessageController::class, 'create'])->middleware('auth');
Route::post('/messages', [MessageController::class, 'store'])->middleware('auth');
Route::post('/messages/{id}/lu', [MessageController::class, 'marquerLu'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';