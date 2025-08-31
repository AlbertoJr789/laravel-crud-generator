<!-- 'bootstrap / Toggle Switch {{ $fieldTitle }} Field' -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div class="checkbox-toggle-switch">
        @{!! Form::checkbox('{{ $fieldName }}', 1, null,  ['class' => 'custom-control-input','wire:model' => '{{$fieldName}}']) !!}
@if($config->options->localized)
        @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':', ['class' => 'custom-control-label block mx-1']) !!}
@else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:', ['class' => 'custom-control-label block mx-1']) !!}
@endif
    </div>
</div>