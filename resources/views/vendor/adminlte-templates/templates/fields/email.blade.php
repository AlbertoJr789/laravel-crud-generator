<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="name">{{ $fieldTitle }} *</Label>
    <Input id="name" type="email" v-model="form.{{ $fieldName }}" :placeholder="t('Enter {{ $fieldTitle }}')" />
</div>