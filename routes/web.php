<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controller\CsvDownloadController;
use App\Http\Controllers\PostController;


/*test用
use App\Http\Controllers\TestController;
Route::get('/test', [TestController::class, 'test'])->name('test');


Route::get('post', [PostController::class,'index'])
->name('post.index');
Route::get('post/create', [PostController::class, 'create']);





Route::post('post',[PostController::class, 'store'])
->name('post.store');
*/
/*Route::get('/', function () {
    return view('welcome');
}) ;*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/image', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/favorite_food', [ProfileController::class, 'Getfavoritefood'])->name('profile.favfood');
});

Route::get('post/view/{user_id}', [PostController::class, 'detail'])
->name('post.detail');

Route::get('post/csv-download', [PostController::class,'PostDownloadCsv'])
->name('post.csvdownload');


//ルート設定の順番に気をつける
// TODO getに変える
Route::get('post', [PostController::class,'search'])
->name('post.index');

Route::post('post/like', [PostController::class, 'like'])
->name('post.like');

Route::post('post/unlike',[PostController::class, 'unlike'])
->name('post.unlike');

Route::get('post/{post}/reply',[PostController::class, 'reply_view'])
->name('post.replyview');

Route::post('post/{post}/reply',[PostController::class, 'reply'])
->name('post.reply');

Route::resource('post', PostController::class);









/*過去のroute
Route::get('post/show/{post}', [PostController::class, 'show'])
->name('post.show');

Route::get('post/{post}/edit', [PostController::class, 'edit'])
->name('post.edit');
Route::patch('post/{post}',[PostController::class, 'update'])
->name('post.update');

Route::delete('post/{post}',[PostController::class, 'destroy'])
->name('post.destroy');
*/

require __DIR__.'/auth.php';
