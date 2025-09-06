<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-3 grid-cols-1">
    <div class="flex flex-col">
        @if($config->options->localized)
        <label for="{{ $fieldName }}">{{ __('models/{{ $config->modelNames->camelPlural }}.fields.{{ $fieldName }}').':') }}</label>
        @else
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        @endif
        <p>@{{ ${!! $config->modelNames->camel !!}->{!! $fieldName !!} }}</p>
    </div>
</div>
