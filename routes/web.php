<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PasswordController;
use App\Http\Middleware\MustBeLoggedIn;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// // Blog post routes
    Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('MustBeLoggedIn');
    Route::post('/store-post', [PostController::class, 'storeNewPost'])->middleware('MustBeLoggedIn');
    Route::get('/post/{post}', [PostController::class, 'viewSinglePost'])->middleware('auth');
// // Profile related routes:
    Route::get('/profile/{user:lidnummer}', [UserController::class, 'showProfile'])->middleware('MustBeLoggedIn');
// --------------------------------------------------------------------------------------------------------------------------------

// <><><><>AQUATORY PROJECT ROUTES<><><><><>
// MODERATOR RELATED ROUTES
Route::get('/beheerder', [UserController::class, 'showModPage'])->middleware('auth', 'IsVerified', 'MustBeAdmin');
Route::post('/opties-opslaan', [TableController::class, 'optiesOpslaan'])->middleware('auth', 'IsVerified');
Route::delete('/profiel/{user}', [TableController::class, 'deleteUser'])->middleware('auth', 'IsVerified', 'MustBeAdmin');
Route::delete('/option/{option}', [UserController::class, 'deleteOption'])->middleware('auth', 'IsVerified', 'MustBeAdmin');

Route::post('/register', [UserController::class, 'register'])->middleware('auth', 'IsVerified', 'MustBeAdmin');
// Uncomment and use the route below for CSV import if needed
// Route::get('/import-csv', [TableController::class, 'importCSV'])->middleware('auth', 'IsVerified', 'MustBeAdmin');

Route::delete('/registratieviabeheerder/{registratie}', [UserController::class, 'modDeleteSingleRegistratie'])->middleware('auth', 'IsVerified', 'MustBeAdmin', 'can:delete,registratie');

// USER RELATED ROUTES
    Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login'); // The name method will mark this route as the route that will be recognized as the page where you will be send if you need to be logged in to visit a certain page.
    Route::post('/login', [UserController::class, 'login'])->middleware('guest');
    Route::post('/logout', [UserController::class, 'logout'])->middleware('MustBeLoggedIn', 'auth');
    Route::get('/visregistratie', [TableController::class, 'registratieFormulier'])->middleware('auth', 'IsVerified');
    Route::post('/registratie-opslaan', [TableController::class, 'registratieOpslaan'])->middleware('auth', 'IsVerified');
    
    Route::get('/profiel/{user:lidnummer}', [UserController::class, 'profiel'])->name('profiel')->middleware('auth', 'MustBeLoggedIn');

    // PROFILE SETTINGS
    Route::middleware('auth', 'MustBeLoggedIn')->group(function () {
        Route::get('/profiel-instellingen', [UserController::class, 'showSettings'])->name('profiel.instellingen');
        Route::post('/profiel/update-name', [UserController::class, 'updateName'])->name('profile.update.name');
        Route::post('/profiel/update-achternaam', [UserController::class, 'updateAchternaam'])->name('profile.update.achternaam');
        Route::post('/profiel/update-email', [UserController::class, 'updateEmail'])->name('profile.update.email');
        Route::post('/profiel/update-password', [UserController::class, 'updatePassword'])->name('profile.update.password');
        Route::post('/profiel/delete-account', [UserController::class, 'deleteAccount'])->name('profile.delete.account');
    });

    Route::get('/registratie/{registratie}', [UserController::class, 'showSingleRegistratie'])->name('registratie.show')->middleware('auth', 'IsVerified');
    Route::delete('/registratie/{registratie', [UserController::class, 'deleteSingleRegistratie'])->middleware('auth', 'IsVerified', 'can:delete,registratie');
    // Fetch, update and delete records from the DB routes
    Route::get('/table-all', [UserController::class,'showTableAll'])->name('showTableAll')->middleware('auth', 'IsVerified', 'MustBeLoggedIn');
    Route::delete('/registratie/{registratie}', [TableController::class, 'deleteRegistratie'])->middleware('auth', 'IsVerified');
    Route::get('/registratie-wijzigen/{registratie}/wijzigen', [UserController::class, 'registratieWijzigenFormulier'])->middleware('auth', 'IsVerified', 'can:update,registratie');
    Route::put('/registratie/{registratie}', [UserController::class, 'registratieWijzigen'])->middleware('can:update,registratie'); 

    // Password reset routes:
    Route::get('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.request')->middleware('guest');
    Route::post('/forgot-password-post', [PasswordController::class, 'forgotPasswordPost'])->name('password.email')->middleware('guest');
    Route::get('/reset-password/{token}', [PasswordController::class, 'getResetForm'])->name('password.reset')->middleware('guest');
    Route::post('/password-reset', [PasswordController::class, 'passwordReset'])->name('password.update')->middleware('guest');

    // first password reset for email verification
    Route::get('/password-reset-from-profile', [UserController::class, 'profilePasswordResetForm']);
    Route::post('/password-reset-from-profile', [UserController::class, 'verificationPasswordResetPost']);

    // Verify user via email routes:
    // sends verification email to new user
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');
    //handles email verification request
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/')->with('success', 'Uw email is nu geverifieerd.');
    })->middleware(['signed'])->name('verification.verify');
    // handles resends verification mail
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'De verificatie link is opnieuw verstuurd naar uw email adres.');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    //Routes that have to do with emails and stuff:
    Route::get('/bulk-email', [AnnouncementController::class, 'bulkEmailPage'])->middleware('MustBeAdmin');