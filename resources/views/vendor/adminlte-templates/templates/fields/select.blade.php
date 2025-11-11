<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
    <Select id="{{ $fieldName }}" v-model="form.{{ $fieldName }}">
        <SelectTrigger>
            <SelectValue :placeholder="t('Select a type')" />
        </SelectTrigger>
        <SelectContent>
            @foreach($htmlValues as $label)
            @php
                $arr = explode(':', $label);
                $key = $arr[0];
                $value = $arr[1] ?? $key;
            @endphp
           <SelectItem :value="{{ $value }}">{{ $key }}</SelectItem>
           @endforeach
        </SelectContent>
    </Select>
</div>