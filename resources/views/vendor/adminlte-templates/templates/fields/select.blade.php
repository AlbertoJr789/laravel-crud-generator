<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div>
        <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
        <select name="{{ $fieldName }}" class="input" required >
            @php echo htmlspecialchars_decode($selectValues) @endphp
        </select>
    </div>
</div>