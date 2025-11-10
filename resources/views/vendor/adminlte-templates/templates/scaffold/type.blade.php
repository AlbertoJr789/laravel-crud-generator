export interface {{ $config->modelNames->name }} {
    @foreach($config->fields as $field)
        {{ $field->name }}{{ $field->name == 'id' ? '?' : '' }}: {{ $field->dbType == 'increments' ? 'number' : 'string' }};
    @endforeach
    active: boolean,
    deleted_at?: string;
    creator_id?: number;
    editor_id?: number;
    deleter_id?: number;
}