<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes de recherche
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/vehicles/filter', [SearchController::class, 'filter'])->name('vehicles.filter');

// Routes d'authentification
Route::controller(AuthController::class)->group(function () {
    // Affichage des formulaires
    Route::get('/welcome', 'welcome')->name('welcome');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/register', 'showRegistrationForm')->name('register');

    // Traitement des formulaires
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');

    // Réinitialisation du mot de passe
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// Routes publiques pour les véhicules
Route::controller(VehicleController::class)->group(function () {
    Route::get('/vehicles', 'index')->name('vehicles.index');
    Route::get('/vehicles/{vehicle}', 'show')->name('vehicles.show');
    Route::get('/brands/{brand}/vehicles', 'byBrand')->name('vehicles.by-brand');
    Route::get('/types/{type}/vehicles', 'byType')->name('vehicles.by-type');
});

// Routes publiques pour les marques et types de véhicules
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/types', [VehicleTypeController::class, 'index'])->name('vehicle-types.index');

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth'])->group(function () {
    // Routes pour les véhicules
    Route::controller(VehicleController::class)->group(function () {
        Route::get('/vehicles/create', 'create')->name('vehicles.create');
        Route::post('/vehicles', 'store')->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', 'edit')->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', 'update')->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', 'destroy')->name('vehicles.destroy');
        Route::put('/vehicles/{vehicle}/sold', 'markAsSold')->name('vehicles.sold');
        Route::put('/vehicles/{vehicle}/available', 'markAsAvailable')->name('vehicles.available');
        Route::post('/vehicles/{vehicle}/images', 'addImages')->name('vehicles.images.add');
        Route::delete('/vehicles/images/{image}', 'removeImage')->name('vehicles.images.remove');
        Route::put('/vehicles/images/{image}/primary', 'setPrimaryImage')->name('vehicles.images.primary');
    });

    // Routes pour les favoris
    Route::controller(FavoriteController::class)->group(function () {
        Route::get('/favorites', 'index')->name('favorites.index');
        Route::post('/favorites/{vehicle}', 'toggle')->name('favorites.toggle');
        Route::delete('/favorites/{vehicle}', 'destroy')->name('favorites.destroy');
    });

    // Routes pour les messages
    Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [App\Http\Controllers\MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{user}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}/reply', [App\Http\Controllers\MessageController::class, 'reply'])->name('messages.reply');
    });

    // Routes pour les avis
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/reviews', 'index')->name('reviews.index');
        Route::post('/vehicles/{vehicle}/reviews', 'store')->name('reviews.store');
        Route::put('/reviews/{review}', 'update')->name('reviews.update');
        Route::delete('/reviews/{review}', 'destroy')->name('reviews.destroy');
    });

    // Routes pour les notifications
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::put('/notifications/{notification}/read', 'markAsRead')->name('notifications.read');
        Route::put('/notifications/read-all', 'markAllAsRead')->name('notifications.read-all');
        Route::delete('/notifications/{notification}', 'destroy')->name('notifications.destroy');
        Route::delete('/notifications', 'destroyAll')->name('notifications.destroy-all');
    });

    // Routes pour le profil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
        Route::get('/profile/password', 'editPassword')->name('profile.edit-password');
        Route::put('/profile/password', 'updatePassword')->name('profile.update-password');
        Route::get('/profile/vehicles', 'vehicles')->name('profile.vehicles');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// Routes d'administration (nécessitent le rôle d'administrateur)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Tableau de bord d'administration
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Gestion des utilisateurs
    Route::resource('users', AdminUserController::class);

    // Gestion des véhicules
    Route::resource('vehicles', AdminVehicleController::class);
    Route::get('/vehicles/{vehicle}', [App\Http\Controllers\VehicleController::class, 'show'])->name('vehicles.show');

    // Gestion des marques
    Route::resource('brands', AdminBrandController::class);

    // Gestion des types de véhicules
    Route::resource('vehicle-types', AdminVehicleTypeController::class);

    // Gestion des avis
    Route::resource('reviews', AdminReviewController::class);

    // Statistiques
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');

    // Paramètres du site
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    //Recherche
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
});

// Fallback route pour les pages non trouvées
Route::fallback(function () {
    return view('errors.404');
});
