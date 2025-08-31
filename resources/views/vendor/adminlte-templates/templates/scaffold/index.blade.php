@@extends('layouts.app')

@@section('content')

@php
$route = "{{route('admin.{$config->modelNames->camelPlural}.dataTableData')}}"
@endphp

<div class="p-3 w-full h-full">
    <x-card class="w-full">
        <Datatable-{{implode('-',explode(' ',$config->modelNames->humanPlural))}} :ajax-route="'{!! $route !!}'"
            :can-create="@@can('testes.create') true @@else false @@endcan"
            :can-delete="@@can('testes.delete') true @@else false @@endcan"
            >
            <template v-slot:toolbar>
                @@can('{{$config->modelNames->camelPlural}}.create')
                <button class="btn-primary" onclick="Livewire.dispatch('openCreate')">
                    <i class="fa-solid fa-plus mr-1"></i> {{__('New')}}
                </button>
                @@endcan
                <button class="btn-primary mx-2" onclick="Livewire.dispatch('openFilter')">
                    <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> {{__('Filter')}}
                </button>
            </template>
        </Datatable-{{implode('-',explode(' ',$config->modelNames->humanPlural))}}>
    </x-card>
</div>

@@push('modals')
@@can('{{$config->modelNames->camelPlural}}.create')
@@livewire('{{$config->modelNames->camelPlural}}.create')
@@endcan
@@livewire('{{$config->modelNames->camelPlural}}.filter')
@@endpush
@@endsection

@@can('{{$config->modelNames->camelPlural}}.delete')
@@push('scripts')
<script>
    function deleteRegister({{$config->modelNames->camel}}){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Delete register')}}",     
                    text: {{$config->modelNames->camel}} instanceof Array ? "{{__('Are you sure you want to delete the selected registers?')}}": "{{__('Are you sure you want to delete this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('delete',[{{$config->modelNames->camel}}])
                    }
                })
            }
            function restoreRegister({{$config->modelNames->camel}}){
                Swal.fire({
                    icon: 'info',
                    title: "{{__('Restore register')}}",     
                    text: {{$config->modelNames->camel}} instanceof Array ? "{{__('Are you sure you want to restore the selected registers?')}}": "{{__('Are you sure you want to restore this register?')}}",
                    showCancelButton: true,
                    confirmButtonText: "{{__('Yes')}}",
                    confirmButtonColor: "#27272A",
                    cancelButtonColor: "#EA4335",
                    cancelButtonText: "{{__('Cancel')}}"     
                }).then((res) => {
                    if(res.value){
                        Livewire.dispatch('restore',[{{$config->modelNames->camel}}])
                    }
                })
            }
</script>
@@endpush
@@endcan