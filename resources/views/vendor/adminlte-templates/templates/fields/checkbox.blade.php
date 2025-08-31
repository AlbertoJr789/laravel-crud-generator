<!-- {{ $fieldTitle }} Field -->
<div class="grid sm:grid-cols-2 grid-cols-1">
    <div class="form-check">
        @{!! Form::hidden('{{ $fieldName }}', 0, ['class' => 'form-check-input']) !!}
        @{!! Form::checkbox('{{ $fieldName }}', '{{ $checkboxVal }}', null, ['class' => 'form-check-input']) !!}
        @{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}', ['class' => 'form-check-label','wire:model' => '{{$fieldName}}']) !!}
    </div>
</div>