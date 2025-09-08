
@php
    $routeIndex = htmlspecialchars_decode("{{ route('{$config->modelNames->camelPlural}.index',['deleted' => true]) }}");
    $routeIndexUndeleted = htmlspecialchars_decode("{{ route('{$config->modelNames->camelPlural}.index',['deleted' => false]) }}");
@endphp
<div class="mt-10 bg-white rounded-lg shadow-lg p-8">
    @@if(!request()->get('deleted'))
        <a href="@php echo $routeIndex @endphp" class="bg-blue-500 text-white px-4 py-2 rounded-md">See deleted {{ $config->modelNames->humanPlural }}</a>
    @@else
        <a href="@php echo $routeIndexUndeleted @endphp" class="bg-blue-500 text-white px-4 py-2 rounded-md">See undeleted {{ $config->modelNames->humanPlural }}</a>
    @@endif
    <div class="mt-4 p3 w-full h-full overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="table{{ ucfirst($config->modelNames->camelPlural) }}">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($config->fields as $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $column->name }}</th>
                        @endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @@foreach($data as $row) 
                    @php $a = '$row->id'; $aux = "data-id=\"{{ $a }}\"" @endphp
                        <tr {!! $aux !!}>
                            @foreach($config->fields as $column)
                            @php $attr = in_array($column->name, ['created_at', 'updated_at']) ? htmlspecialchars_decode("{{ \$row->{$column->name}->diffForHumans() }}") : htmlspecialchars_decode("{{ \$row->{$column->name} }}"); @endphp
                            <td class="px-6 py-4 whitespace-nowrap" name="{{ $column->name }}">@php echo $attr; @endphp</td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Action Buttons. -->
                                @@include('{{$config->modelNames->snakePlural}}.action-buttons',['data' => $row])
                            </td>
                        </tr>
                    @@endforeach
                </tbody>
            </table>
        </div>
</div>

@php
    $routeUpdate = htmlspecialchars_decode("{{ route('{$config->prefixes->getRoutePrefixWith('.')}{$config->modelNames->camelPlural}.update', '0') }}");
    $routeStore = htmlspecialchars_decode("{{ route('{$config->prefixes->getRoutePrefixWith('.')}{$config->modelNames->camelPlural}.store') }}");
@endphp

@@push('scripts')
    <script>
      
        function edit(id){
            let table{{ ucfirst($config->modelNames->camelPlural) }} = document.getElementById('table{{ ucfirst($config->modelNames->camelPlural) }}');
            let row = table{{ ucfirst($config->modelNames->camelPlural) }}.querySelector(`tr[data-id='${id}']`);

            @foreach($config->fields as $column)
            @if(!in_array($column->name, ['id', 'created_at', 'updated_at']))
        let {{ $column->name }} = row.querySelector(`td[name='{{ $column->name }}']`).textContent;
            document.querySelector(`input[name='{{ $column->name }}']`).value = {{ $column->name }};

            @endif
            @endforeach
                    
            let href = `@php echo $routeUpdate @endphp`
            href = href.replace('/0', `/${id}`);

            let form = document.getElementById('form{{ ucfirst($config->modelNames->camelPlural) }}');
            form.setAttribute('action', href);
            form.setAttribute('method', 'POST');
            form.querySelector('input[name="_method"]').value = 'PATCH';

            let cancel{{ ucfirst($config->modelNames->camelPlural) }}Button = document.getElementById('cancel{{ ucfirst($config->modelNames->camelPlural) }}Button');
            cancel{{ ucfirst($config->modelNames->camelPlural) }}Button.classList.remove('hidden');

            document.getElementById('create{{ ucfirst($config->modelNames->camelPlural) }}').textContent = 'Update {{ $config->modelNames->humanPlural }}';

        }

        function cancelEdit(){
            let form = document.getElementById('form{{ ucfirst($config->modelNames->camelPlural) }}');
            form.setAttribute('action', `@php echo $routeStore @endphp`);
            form.setAttribute('method', 'POST');
            form.querySelector('input[name="_method"]').value = 'POST';

            let cancel{{ ucfirst($config->modelNames->camelPlural) }}Button = document.getElementById('cancel{{ ucfirst($config->modelNames->camelPlural) }}Button');
            cancel{{ ucfirst($config->modelNames->camelPlural) }}Button.classList.add('hidden');

            document.getElementById('create{{ ucfirst($config->modelNames->camelPlural) }}').textContent = 'Create new {{ $config->modelNames->humanPlural }}';

            form.reset();
        }

        document.addEventListener('DOMContentLoaded', function(){
            let form = document.getElementById('form{{ ucfirst($config->modelNames->camelPlural) }}');
            form.setAttribute('action', `@php echo $routeStore @endphp`);
            form.setAttribute('method', 'POST');
            form.querySelector('input[name="_method"]').value = 'POST';
        });

    </script>
@@endpush
