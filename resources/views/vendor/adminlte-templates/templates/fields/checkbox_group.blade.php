<!-- {{ $fieldTitle }} Field -->
<div>
    @if($config->options->localized)
        <label for="{{ $fieldName }}">{{ __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') }}</label>
    @else
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
    @endif
    @if($config->options->localized)
        <label for="{{ $fieldName }}">{{ __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') }}</label>
    @else
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
    @endif
        {!! $checkboxes !!}
</div>