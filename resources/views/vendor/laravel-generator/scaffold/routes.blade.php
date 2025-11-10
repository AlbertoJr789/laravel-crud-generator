@php
    $edit = "{{$config->modelNames->camel}}";
@endphp
Route::group(['prefix' => '{{$config->modelNames->dashedPlural}}', 'as' => '{{$config->modelNames->dashedPlural}}.'], function () {
    Route::get('', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'index'])->name('index')->middleware('can:{{$config->modelNames->snakePlural}}.view')->defaults('required_permissions', ['{{$config->modelNames->snakePlural}}.create','{{$config->modelNames->snakePlural}}.delete']);
    Route::get('create', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'create'])->name('create')->middleware('can:{{$config->modelNames->snakePlural}}.create');
    Route::get('{{$edit}}/edit', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'edit'])->name('edit')->middleware('can:{{$config->modelNames->snakePlural}}.create');
    Route::post('', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'store'])->name('store')->middleware('can:{{$config->modelNames->snakePlural}}.create');
    Route::patch('{{$edit}}', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'update'])->name('update')->middleware('can:{{$config->modelNames->snakePlural}}.create');
    Route::post('deleteAll', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'deleteAll'])->name('deleteAll')->middleware('can:{{$config->modelNames->snakePlural}}.delete');
    Route::post('restoreAll', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'restoreAll'])->name('restoreAll')->middleware('can:{{$config->modelNames->snakePlural}}.delete');
    Route::post('dataTableData', [{{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class, 'dataTableData'])->name('dataTableData')->middleware('can:{{$config->modelNames->snakePlural}}.view');
});