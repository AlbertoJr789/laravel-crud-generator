<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
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