<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <input type="number" name="{{ $fieldName }}" class="form-control" @php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp >
    </div>
</div>