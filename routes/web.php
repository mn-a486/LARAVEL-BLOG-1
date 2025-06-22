<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;



// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// allow the user to user all the routes inside if the user is logged in
Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [PostController::class, 'index'])->name('index');

    # POST
    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('{id}/delete', [PostController::class, 'delete'])->name('delete');
        Route::get('/search', [PostController::class, 'search'])->name('search');
    });

    # COMMENT
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function(){
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [CommentController::class, 'update'])->name('update');
    });

    # USER
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/edit', [UserController::class,'edit'])->name('edit');
        Route::get('/{user_id}', [UserController::class,'see'])->name('see');
        Route::get('/', [UserController::class,'show'])->name('show');
        Route::patch('/update', [UserController::class,'update'])->name('update');
    });

    # CATEGORY
    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::get('/', [CategoryController::class, 'index'])->name('index');

            # Admin
            Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::post('/store', [CategoryController::class, 'store'])->name('store');
                Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
                Route::patch('/{category}/update', [CategoryController::class, 'update'])->name('update');
                Route::delete('/{category}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
            });

        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
    });


});
