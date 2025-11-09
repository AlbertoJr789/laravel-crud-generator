<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
    <Datepicker v-model="form.{{ $fieldName }}" />
</div>

