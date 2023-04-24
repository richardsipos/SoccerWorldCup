<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeanController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;

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

Route::get('/', function () {
    return view('welcome');
})->name('/');


// Route::get('/merkozesek',function(){
//     return view('games.index');
// });

//Route::resource('merkozesek', GameController::class);
Route::resource('games', GameController::class);
Route::resource('teams', TeamController::class);



// Route::get('/csapatok',function(){
//     return view('teams.index');
// });
// Route::resource('csapatok', TeamController::class);


// Route::get('/tabella',function(){
//     return view('leaderboards.index');
// });
// Route::resource('tabella', TeamController::class);


// Route::get('/kedvenceim',function(){
//     return view('favorites.index');
// });
// Route::resource('kedvenceim', TeamController::class);







Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
