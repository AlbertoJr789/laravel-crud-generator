@verbatim
<x-dialog-modal wire:model.live="open" id="modalCreate">
    <x-slot name="title">@endverbatim
        @@if(${{$config->modelNames->name}})
            @{{__('Update register')}}
        @@else
            @{{__('Create new register')}}
        @@endif @verbatim
    </x-slot>

    <x-slot name="content"> @endverbatim
        @@include('adminlte-templates::common.errors')
        @{!! Form::model(${{$config->modelNames->name}},['route' => ${{$config->modelNames->name}} ? ['admin.{{$config->modelNames->camelPlural}}.update',${{$config->modelNames->name}}->id] : 'admin.{{$config->modelNames->camelPlural}}.store', 'method' => ${{$config->modelNames->name}} ? 'PATCH' : 'post','id' => 'form{{$config->modelNames->plural}}']) !!}

            <div wire:key='{{$config->modelNames->camelPlural}}'> @verbatim
               <x-stepper>
                    <x-stepper-item icon="fa-solid fa-info" active-stepper="0"/>
                </x-stepper> @endverbatim
                <div class="my-2" stepper-fields >
                    <div>
                        <h1 class="m-auto text-2xl">@{{__('Info')}}</h1>
                        @@include('{{$config->modelNames->snakePlural}}.fields')
                    </div>
                </div>
            </div>


    @verbatim </x-slot> @endverbatim
        @verbatim
    <x-slot name="footer">
        <x-button class="btn-primary ml-3" type="submit"> @endverbatim
            @@if(${{$config->modelNames->name}}) @{{__('Update') }} @@else @{{__('Add')}} @@endif @verbatim
          </div>
        </x-button>
        {!! Form::close() !!}
    </x-slot>
</x-dialog-modal> @endverbatim