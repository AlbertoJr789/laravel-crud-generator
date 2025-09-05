<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <label class="checkbox-inline block mx-1">
        <input type="checkbox" name="{{ $fieldName }}" value="1"  checked>
        <!-- remove {, true} to make it unchecked by default -->
        </label>
    </div>
</div>