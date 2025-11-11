<!-- 'bootstrap / Toggle Switch {{ $fieldTitle }} Field' -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <Switch id="{{ $fieldName }}" v-model="form.{{ $fieldName }}" />
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
</div>