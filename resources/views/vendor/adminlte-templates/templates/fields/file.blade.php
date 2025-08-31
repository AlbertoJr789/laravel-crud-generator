<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
@if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':',['class'=>"block mx-1"]) !!}
@else
    @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:',['class'=>"block mx-1"]) !!}
@endif
    <div class="input-group">
        <div class="custom-file">
            @{!! Form::file('{{ $fieldName }}', ['class' => 'custom-file-input']) !!}
            @{!! Form::label('{{ $fieldName }}', 'Choose file', ['class' => 'custom-file-label','wire:model' => '{{$fieldName}}']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>