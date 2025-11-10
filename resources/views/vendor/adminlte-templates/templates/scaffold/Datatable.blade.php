<script setup lang="ts">
    import DataTable from 'datatables.net-vue3';
    import 'datatables.net-responsive';
    import 'datatables.net-fixedheader-dt';
    import 'datatables.net-buttons-dt';
    import 'datatables.net-buttons/js/buttons.colVis.js';
    import DataTablesCore, { Config, ConfigColumns } from 'datatables.net';
    import { computed, ref } from 'vue';
    import { handleCheckboxes, dataTableButtons, dataTableLengthMenu, dataTableDom } from '@/lib/utils';
    import { useI18n } from 'vue-i18n';
    import '../../../css/dataTables.css';
    import '../../../css/datatablesLoader.css';
    import { createIcons, icons } from 'lucide';
    import { router } from '@inertiajs/vue3';
    import Button from '@/components/ui/button/Button.vue';
    import ActionDialog from '@/components/ui/alert-dialog/ActionDialog.vue';
    import { getStandardFilterData } from './filter';
    import { usePage } from '@inertiajs/vue3';

    const page = usePage();
    const can = (page.props.can as Record<string, boolean>);

    const { t,locale } = useI18n();
    DataTable.use(DataTablesCore);

    const table = ref()
    const checked = ref<number[]>([])
    const toolbarRef = ref()

    const filterData = ref(getStandardFilterData());

    const columns : ConfigColumns[] = [
        { responsivePriority: 0, data: 'select', name: 'select', className:'text-center noVis', orderable: false, searchable: false, visible: true},
        ...(can['{{ $config->modelNames->snakePlural }}.delete'] ? [{ responsivePriority: 2, data: 'select', name: 'select', title: `<div class="mx-0">
            <input class="input input-checkbox" type="checkbox" value="-1" id="table{{ $config->modelNames->camel }}_headerCheckbox"/></div>`, 
            className:'text-center noVis', orderable: false, searchable: false, visible: true, width: '20px'}] : []),
        @foreach($config->fields as $field)
        {data: '{{ $field->name }}', title: t('{{ $field->name }}')},
        @endforeach
        {data: 'active', title: t('active')},
        {data: 'creator', name:'creator.name', title: t('creator')},
        {data: 'editor', name:'editor.name', title: t('editor')},
        {data: 'deleter', name:'deleter.name', title: t('deleter')},
        {data: 'deleted_at', title: t('deleted at')},
        { responsivePriority: 2, data: 'action', name: 'action', title: '', className:'text-center noVis', orderable: false, searchable: false, width: '50px'},

    ].filter(Boolean)


    const language = computed(() => {
        const lang = locale.value ?? 'en_US';
        
        return {
            url: `../../../lang/${lang}/datatables.json`
        }
    })

    const options : Config = {
        language: language.value,
        buttons: dataTableButtons,
        fixedHeader: true,
        responsive: true,
        serverSide: true,
        processing: true,
        stateSave: true,
        order: can['{{ $config->modelNames->snakePlural }}.delete'] ? [[2,'desc']] : [[1,'desc']],
        dom: dataTableDom,
        columnDefs: [
            ...(can['{{ $config->modelNames->snakePlural }}.delete'] ? [{
                targets: 1, // Primeira coluna quando select existe
                orderable: false,
                render: function ( val: any, type: any, row: any ) {
                    return `<div class="mx-0">
                                <input class="input input-checkbox border-black" type="checkbox" value="${row.id}"/>
                            </div>`;
                }
            }] : []),
            {
                targets: columns.findIndex(column => column.data === 'active'),
                orderable: false,
                render: function ( val: any, type: any, row: any ) {
                    return row.active ? '<span class="badge badge-success uppercase">'+t('Yes')+'</span>' : '<span class="badge badge-danger uppercase">'+t('No')+'</span>';
                }
            },
            {
                targets: -1,
                orderable: false,
                render: function ( val: any, type: any, row: any ) {
                    let btns = ''
                    let delete_btn = can['{{ $config->modelNames->snakePlural }}.delete'] ? `<button class="btn btn-danger btn-remove btn-xs px-2 py-1" data-id="${row.id}">
                                   <i data-lucide="trash-2"></i>
                                </button>` : '';
                    let restore_btn = can['{{ $config->modelNames->snakePlural }}.delete'] ? `<button class="btn btn-primary btn-restore btn-xs px-2 py-1" data-id="${row.id}">
                                   <i data-lucide="archive-restore"></i>
                                </button>` : '';
                    let edit_btn = can['{{ $config->modelNames->snakePlural }}.create'] ? `<button class="btn btn-primary btn-edit btn-xs px-2 py-1" data-id="${row.id}">
                                   <i data-lucide="square-pen"></i>
                                </button>` : '';

                    if (row.deleted_at) {
                        btns = restore_btn;
                    } else {
                        btns = edit_btn + delete_btn;
                    }
                    return `<div class="flex justify-end gap-2">
                                ${btns}
                            </div>`;
                }
            }
        ],
        initComplete: () => {
            if(can['{{ $config->modelNames->snakePlural }}.delete'])
                handleCheckboxes(document.getElementById('table{{ $config->modelNames->camel }}') as HTMLTableElement,checked)
            
            const toolbarContainer = document.querySelector('#table{{ $config->modelNames->camel }}_wrapper .toolbar');
            const toolbarContent = toolbarRef.value;
            
            if (toolbarContainer && toolbarContent) {
                toolbarContainer.appendChild(toolbarContent);
                toolbarContent.classList.remove('hidden');
            }
            
            const table = document.getElementById('table{{ $config->modelNames->camel }}');
            if (table) {
                table.addEventListener('click', (e) => {
                    const target = e.target as HTMLElement;
                    const button = target.closest('.btn-edit, .btn-remove, .btn-restore') as HTMLElement;
                    
                    if (button) {
                        const id = parseInt(button.getAttribute('data-id') || '0');
                        
                        if (button.classList.contains('btn-edit')) {
                            edit(id);
                        } else if (button.classList.contains('btn-remove')) {
                            remove(id);
                        } else if (button.classList.contains('btn-restore')) {
                            restore(id);
                        }
                    }
                });
            }
        },
        drawCallback: () => {
            if(can['{{ $config->modelNames->snakePlural }}.delete']){
                (document.getElementById('table{{ $config->modelNames->camel }}_headerCheckbox') as HTMLInputElement).checked = false
                checked.value = []
            }
            createIcons({ icons });
        },
        lengthMenu: dataTableLengthMenu
    };

    const ajax = {
        url: '/{{ $config->modelNames->dashedPlural }}/dataTableData',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')!.getAttribute('content'),
        },
        data: (d: any) => {
            if(filterData.value){
                for (const key in filterData.value) {
                    d[key] = filterData.value[key as keyof typeof filterData.value];
                }
            }
        }
    }

    function edit(id: number){
        let href = `/{{ $config->modelNames->dashedPlural }}/${id}/edit`
        router.visit(href)
    }

    const actionData = ref<number | number[]>([])
    const action = ref<'delete' | 'restore'>('delete')
    const actionHref = ref<string>('')
    const openActionDialog = ref<boolean>(false)

    function remove(id: number | number[]){
        actionData.value = id;
        action.value = 'delete';
        actionHref.value = '/{{ $config->modelNames->dashedPlural }}/deleteAll';
        openActionDialog.value = true;
    }

    function restore(id: number | number[]){
        actionData.value = id;
        action.value = 'restore';
        actionHref.value = '/{{ $config->modelNames->dashedPlural }}/restoreAll';
        openActionDialog.value = true;
    }

    function closeActionDialog(refresh: boolean){
        openActionDialog.value = false;
        if(refresh){
            table.value.dt.ajax.reload();
        }
    }

    defineExpose({
        table,
        filterData
    })

</script>

<template>
    <!-- Toolbar content que será movido para dentro do DataTable -->
    <div ref="toolbarRef" class="hidden">
        <slot name="toolbar"></slot>
        <div v-if="checked.length && can['{{ $config->modelNames->snakePlural }}.delete']" class="md:inline ml-2"> @verbatim
            <Button v-if="filterData?.dateTypeFilter !== 'D'" variant="destructive" @click="remove(checked)">{{ t('Delete') }}</Button>
            <Button v-else variant="outline" @click="restore(checked)">{{ t('Restore') }}</Button>
            {{ checked.length }} {{ t('Elements Selected') }}
        </div>
    </div> @endverbatim
    <DataTable :columns="columns" :ajax="ajax" :options="options" ref="table" class="display responsive border border-transparent border-separate border-spacing-0 rounded-lg" id="table{{ $config->modelNames->camel }}">
        <thead class="text-xs text text-amber-300 uppercase hover:cursor-pointer">
            <tr class="border">
                <th v-for="_ in columns" scope="col" class="px-6 py-3 first:rounded-tl-lg last:rounded-tr-lg bg-secondary ">
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th v-for="_ in columns" class="first:rounded-bl-lg last:rounded-br-lg py-4 bg-secondary"></th>
            </tr>
        </tfoot>
    </DataTable>

    <ActionDialog :data="actionData" :action="action" :href="actionHref" v-model:open="openActionDialog" @close="closeActionDialog" />
</template>
