Route::group(['prefix' => '{{$config->modelNames->camelPlural}}', 'as' => '{{$config->modelNames->camelPlural}}.'],function(){
    Route::resource('/', {{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class);
    Route::delete('/{id}', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'destroy'])->name('destroy');
    Route::patch('/update/{id}', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'update'])->name('update');
    Route::post('/{id}/restore', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'restore'])->name('restore');
});