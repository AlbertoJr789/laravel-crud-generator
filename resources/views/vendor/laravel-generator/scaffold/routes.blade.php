Route::group(['prefix' => '{{$config->modelNames->camelPlural}}', 'as' => '{{$config->modelNames->camelPlural}}.'],function(){
    Route::resource('/', {{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class);
});