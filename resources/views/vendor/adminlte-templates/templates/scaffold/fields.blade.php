<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    @if($config->options->localized)
    @{!! Form::label('{{ $fieldName }}', __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') !!}
    @else
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}
    @endif
        <p>@{{ ${!! $config->modelNames->camel !!}->{!! $fieldName !!} }}</p>
</div>
