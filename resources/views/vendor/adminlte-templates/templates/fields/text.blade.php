<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <input type="text" name="{{ $fieldName }}" class="input" required @php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp>
    </div>
</div>