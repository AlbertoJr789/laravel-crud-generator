<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        @if($config->options->localized)
            @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
        @else
            @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}
        @endif
            <label class="checkbox-inline block mx-1">
            @{!! Form::checkbox('{{ $fieldName }}', 1, true,['wire:model' => '{{$fieldName}}']) !!}
            <!-- remove {, true} to make it unchecked by default -->
            </label>
    </div>
</div>