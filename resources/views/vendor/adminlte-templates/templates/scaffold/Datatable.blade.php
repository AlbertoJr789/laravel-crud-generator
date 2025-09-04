@verbatim
<div class="p-3 w-full h-full">
    <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="datatable">
                <thead class="bg-gray-50">
                    <tr>
                        <!-- Substitua pelos nomes das colunas dinamicamente -->
                        @@foreach($columns as $column)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                @{{ __($column['title']) }}
                            </th>
                        @@endforeach
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            @{{ __('Ações') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @@foreach($data as $row)
                        <tr>
                            @@foreach($columns as $column)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @{{ $row[$column['name']] }}
                                </td>
                            @@endforeach
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Botões de ação: editar, excluir, etc. -->
                                <x-button class="btn-primary btn-sm" onclick="editRegister(@{{ $row['id'] }})">
                                    <i class="fa fa-edit"></i>
                                </x-button>
                                <x-button class="btn-danger btn-sm" onclick="deleteRegister(@{{ $row['id'] }})">
                                    <i class="fa fa-trash"></i>
                                </x-button>
                            </td>
                        </tr>
                    @@endforeach
                </tbody>
            </table>
        </div>
</div>
@endverbatim
