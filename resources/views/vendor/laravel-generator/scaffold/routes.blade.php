Route::group(['prefix' => '{{$config->modelNames->camelPlural}}', 'as' => '{{$config->modelNames->camelPlural}}.', 'middleware' => 'permission:{{$config->modelNames->camel}}.view'],function(){
    Route::resource('/', {{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class);
    @php
        $modelRouteEdit = '{'.$config->modelNames->camel.'}';
    @endphp
    Route::patch('/update/{{$modelRouteEdit}}', [App\Http\Controllers\{{ $config->modelNames->name }}Controller::class,'update'])->name('update');
    Route::get('dataTableData',[App\Http\Controllers\{{ $config->modelNames->name }}Controller::class,'dataTableData'])->name('dataTableData');
});