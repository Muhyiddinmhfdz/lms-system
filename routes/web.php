<?php

use App\Http\Controllers\Course\CartController;
use App\Http\Controllers\Course\CategoryCourseController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\ListCourseController;
use App\Http\Controllers\Course\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\DepartementController;
use App\Http\Controllers\Master\EducationController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Dashboard
Route::name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('master.')->prefix('master')->middleware('auth')->group(function () {
    // user
    Route::name('user.')->controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/show/{user:id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{user:id}', 'update')->name('update');
        Route::post('/delete/{user:id}', 'delete')->name('delete');
    });

    // role
    Route::name('role.')->controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/detail/{role:id}', 'detail')->name('detail');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{role:id}', 'update')->name('update');
    });

    // education
    Route::name('education.')->controller(EducationController::class)->prefix('education')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('/insert', 'insert')->name('insert');
        Route::get('/detail/{education:id}', 'detail')->name('detail');
        Route::post('/update/{education:id}', 'update')->name('update');
        Route::post('/changeStatus/{education:id}', 'changeStatus')->name('changeStatus');
    });

    // departement
    Route::name('departement.')->controller(DepartementController::class)->prefix('departement')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('/insert', 'insert')->name('insert');
        Route::get('/detail/{departement:id}', 'detail')->name('detail');
        Route::post('/update/{departement:id}', 'update')->name('update');
        Route::post('/changeStatus/{departement:id}', 'changeStatus')->name('changeStatus');
    });
});

Route::name('student.')->prefix('student')->middleware('auth')->controller(StudentController::class)->group(function () {
    Route::get('/index', 'index')->name('index');
    Route::get('/data', 'data')->name('data');
    Route::get('/profile/{user:id}', 'profile')->name('profile');
    Route::get('/get_education/{education:id}', 'get_education')->name('get_education');
    Route::post('/update/{user:id}', 'update')->name('update');
});

Route::name('course.')->prefix('course')->middleware('auth')->group(function () {
    // education
    Route::name('category.')->controller(CategoryCourseController::class)->prefix('category')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('/insert', 'insert')->name('insert');
        Route::get('/detail/{category:id}', 'detail')->name('detail');
        Route::post('/update/{category:id}', 'update')->name('update');
        Route::post('/changeStatus/{category:id}', 'changeStatus')->name('changeStatus');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/create', 'create')->name('create');
        Route::post('/insert', 'insert')->name('insert');
        Route::get('/edit/{course:id}', 'edit')->name('edit');
        Route::post('/update/{course:id}', 'update')->name('update');
        Route::post('/changeStatus/{course:id}', 'changeStatus')->name('changeStatus');
        Route::get('/my_course', 'my_course')->name('my_course');
        Route::get('/detail_course/{slug}', 'detail_course')->name('detail_course');
    });

    Route::name('list.')->controller(ListCourseController::class)->prefix('list')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/course/{slug}', 'detail')->name('detail');
        Route::get('/order', 'order')->name('order');
        Route::get('/data_order', 'data_order')->name('data_order');
        Route::post('/update_order/{order}', 'update_order')->name('update_order');
    });

    Route::name('cart.')->controller(CartController::class)->prefix('cart')->group(function () {
        Route::post('/cart/{course}', 'store')->name('store');
        Route::get('/cart', 'index')->name('index');
        Route::post('/checkout/{course}', 'checkout')->name('checkout.now');
    });

    Route::name('order.')->controller(OrderController::class)->prefix('order')->group(function () {
        Route::post('store', 'store')->name('store');
        Route::get('pending/{order}', 'pending')->name('pending');
    });
});

require __DIR__.'/auth.php';
