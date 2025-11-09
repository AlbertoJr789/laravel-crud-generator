<!-- {{ $fieldTitle }} Field -->
<div>
    <Label for="{{ $fieldName }}">{{ $fieldTitle }}:</Label>
    <select name="{{ $fieldName }}" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
       
    </select>
    <Select id="type" v-model="form.type">
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