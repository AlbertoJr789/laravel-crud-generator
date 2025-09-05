<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>  
    <div class="input-group">
        <div class="custom-file">
            <input type="file" name="{{ $fieldName }}" class="custom-file-input" >
            <label for="{{ $fieldName }}" class="custom-file-label" >Choose file</label>
        </div>
    </div>
</div>