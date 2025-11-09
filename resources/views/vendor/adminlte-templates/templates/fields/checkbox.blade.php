<!-- {{ $fieldTitle }} Field -->
<div>
    <Checkbox :id="`{{ $fieldName }}`" v-model="form.{{ $fieldName }}"/>
    <Label :for="`{{ $fieldName }}`">{{ $fieldTitle }}</Label>
</div>