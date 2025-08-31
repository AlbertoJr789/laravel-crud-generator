
@php
    $menu = "{{ __('{$config->modelNames->humanPlural}') }}";
    $route = "{{route('admin.{$config->modelNames->camelPlural}.index')}}";
    $routeIs = "Route::is('$route')"
@endphp

@@can('{{$config->modelNames->camelPlural}}.view')  @verbatim
<x-menu-item icon="fa-solid fa-pen" @endverbatim route="{!! $route !!}" :active="{{$routeIs}}">
        {!! $menu !!} @verbatim
</x-menu-item>@endverbatim
@@endcan


