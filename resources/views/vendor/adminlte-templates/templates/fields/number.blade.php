<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
    <Input id="{{ $fieldName }}" type="number" v-model="form.{{ $fieldName }}" />
</div>