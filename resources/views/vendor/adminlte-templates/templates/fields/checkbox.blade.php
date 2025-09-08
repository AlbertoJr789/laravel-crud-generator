<!-- {{ $fieldTitle }} Field -->
<div>
    <label for="{{ $fieldName }}">{{ $fieldTitle }}:</label>
    <input type="hidden" name="{{ $fieldName }}" value="0" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    <input type="checkbox" name="{{ $fieldName }}" value="{{ $checkboxVal }}" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" >
    <label for="{{ $fieldName }}">{{ $fieldTitle }}</label>
</div>