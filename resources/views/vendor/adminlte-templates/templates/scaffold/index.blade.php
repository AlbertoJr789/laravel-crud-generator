@@extends('layouts.app')

@@section('content')

@php
$route = "{{route('admin.{$config->modelNames->camelPlural}.dataTableData')}}"
@endphp

<div class="p-3 w-full h-full">
    @@include('{{$config->modelNames->snakePlural}}.datatable')  
</div>
