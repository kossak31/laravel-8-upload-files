<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    //redirect route with name
    return redirect()->route('create.form');
});

//create view with form
Route::get('upload/file', [\App\Http\Controllers\FileController::class, 'create'])->name('create.form');

//POST link to store images
Route::post('upload/file', [\App\Http\Controllers\FileController::class, 'store'])->name('post.form');


//convert json to array and show images in database
Route::get('/show/images-files', function () {

    //href link with route
    echo "<a href='" . route('create.form') . "'>upload form</a><br>";

    //get json file
    foreach (\App\Models\File::all() as $json_image_file) {

        //decode json to php array
        $php_array = json_decode($json_image_file->filenames);

        //display php array
        foreach ($php_array as $item) {

            //<img src='http://127.0.0.1:8000/files/1848551284_1616091979.jpg'>
            echo "<img src='" . asset('files') . "/" . $item . "'><br>";
        }
    }
})->name('list.images');
