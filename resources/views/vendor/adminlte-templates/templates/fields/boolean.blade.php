<!-- 'Boolean {{ $fieldTitle }} Field' checked by default -->
<div>
    <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
    <input type="checkbox" name="{{ $fieldName }}" value="1" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" checked>
    <!-- remove {, true} to make it unchecked by default -->
    </label>
</div>
