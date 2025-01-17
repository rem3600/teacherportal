<?php

use App\Models\Location;
use App\Models\Teacher;
use App\Models\Category;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\RegistrationController;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     $teachers = Teacher::all();
//     $locations = Location::all();
//     $categories = Category::all();
//     return view('home', compact('teachers', 'locations', 'categories'));
// })->name('home');

Route::get('/', [TeacherController::class, 'index'])->name('home');

Route::get('/search', [TeacherController::class, 'search']);
Route::get('/category', [TeacherController::class, 'searchByCategory']);
Route::get('/campuslocation', [TeacherController::class, 'searchByCampusLocation']);
Route::get('/teacherlocation', [TeacherController::class, 'searchByTeacherLocation']);



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store']);

// Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [UserController::class, 'register']);

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);

// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/teachercontact/{id}', [TeacherController::class, 'contact'])->name('teachercontact');

Route::get('/send-email/{id}', function ($id) {
    $teacher = Teacher::find($id); // Retrieve the user from the database

    Mail::to($teacher->email)->send(new SendEmail($teacher, $id));

    dd('Mail sent!');
});