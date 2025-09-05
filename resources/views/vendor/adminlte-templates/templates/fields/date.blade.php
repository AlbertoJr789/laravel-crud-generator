<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <input type="datetime-local" name="{{ $fieldName }}" class="input" id="{{ $fieldName }}" required>
    </div>
</div>
