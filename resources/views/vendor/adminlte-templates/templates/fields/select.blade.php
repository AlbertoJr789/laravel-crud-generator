<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
<div>
    @if($config->options->localized)
        @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':',['class' => "block mx-1"]) !!}
    @else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:',['class' => "block mx-1"]) !!}
    @endif
        @{!! Form::select('{{ $fieldName }}', @php echo htmlspecialchars_decode($selectValues) @endphp, null, ['class' => 'input','required' => 'true','wire:model' => '{{$fieldName}}']) !!}
</div>
</div>