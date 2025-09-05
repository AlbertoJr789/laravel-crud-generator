
Route::group(['prefix' => 'testes', 'as' => 'testes.', 'middleware' => 'permission:teste.view'],function(){
    Route::resource('/', App\Http\Controllers\TesteController::class);
        Route::patch('/update/{teste}', [App\Http\Controllers\TesteController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\TesteController::class,'dataTableData'])->name('dataTableData');
});
Route::group(['prefix' => 'testes', 'as' => 'testes.', 'middleware' => 'permission:teste.view'],function(){
    Route::resource('/', App\Http\Controllers\testeController::class);
        Route::patch('/update/{teste}', [App\Http\Controllers\testeController::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\testeController::class,'dataTableData'])->name('dataTableData');
});