<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
    @if($config->options->localized)
        @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':',['class' => "block mx-1"]) !!}
    @else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:',['class' => "block mx-1"]) !!}
    @endif
        @{!! Form::textarea('{{ $fieldName }}', null, ['class' => 'form-control'@php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp,'wire:model' => '{{$fieldName}}']) !!}
</div>
</div>