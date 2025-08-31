<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
    @if($config->options->localized)
        @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':',['class' => "block mx-1"]) !!}
    @else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:',['class' => "block mx-1"]) !!}
    @endif
        @{!! Form::text('{{ $fieldName }}', null, ['class' => 'input','required' => 'true','wire:model' => '{{$fieldName}}' @php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp]) !!}
</div>
</div>