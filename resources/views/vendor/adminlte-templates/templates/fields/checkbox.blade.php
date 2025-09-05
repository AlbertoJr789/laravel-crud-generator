<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div class="form-check">
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <input type="hidden" name="{{ $fieldName }}" value="0" class="form-check-input">
        <input type="checkbox" name="{{ $fieldName }}" value="{{ $checkboxVal }}" class="form-check-input" >
        <label for="{{ $fieldName }}">{{ $fieldTitle }}</label>
    </div>
</div>