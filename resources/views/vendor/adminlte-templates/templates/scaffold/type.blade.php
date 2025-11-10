export interface {{ $config->modelNames->name }} {
    @foreach($config->fields as $field)
        {{ $field->name }}: {{ $field->dbType == 'increments' ? 'number' : 'string' }};
    @endforeach
}