
<div class="p-3 w-full h-full">
    <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="datatable">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($config->fields as $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $column->name }}</th>
                        @endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{-- Action Buttons.Header --}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @@foreach($data as $row)
                        <tr>
                            @foreach($config->fields as $column)
                                @php
                                    $attr = htmlspecialchars_decode("{{ \$row->{$column->name} }}");
                                @endphp
                                <td class="px-6 py-4 whitespace-nowrap">@php echo $attr @endphp</td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Action Buttons. -->
                                @@include('{{$config->modelNames->snakePlural}}.action-buttons')
                            </td>
                        </tr>
                    @@endforeach
                </tbody>
            </table>
        </div>
</div>

