<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
    <Input id="{{ $fieldName }}" type="text" v-model="form.{{ $fieldName }}" :placeholder="t('Enter {{ $fieldTitle }}')" />
</div>