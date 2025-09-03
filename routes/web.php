<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::post('set_crud_path', function(Request $request){
    $path = base_path('.env');

    $key = 'CRUD_PATH';
    $value = $request->path;
    
    if (file_exists($path)) {
        // Escape special characters
        $value = preg_replace('/\s+/', ' ', trim($value));

        // Replace if exists, else append
        if (strpos(file_get_contents($path), "$key=") !== false) {
            file_put_contents(
                $path,
                preg_replace(
                    "/^$key=.*/m",
                    "$key=\"$value\"",
                    file_get_contents($path)
                )
            );
        } else {
            file_put_contents($path, PHP_EOL . "$key=\"$value\"", FILE_APPEND);
        }
    }
})->name('set_crud_path');
