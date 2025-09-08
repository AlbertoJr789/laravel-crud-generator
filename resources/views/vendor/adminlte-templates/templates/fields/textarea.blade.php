<!-- {{ $fieldTitle }} Field -->
<div>
    <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
    <textarea name="{{ $fieldName }}" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" @php if(isset($options)) { echo htmlspecialchars_decode($options); } @endphp ></textarea>
</div>