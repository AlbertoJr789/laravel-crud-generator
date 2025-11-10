<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed, ref } from 'vue';
import Datatable from './{{ $config->modelNames->snakePlural }}/Datatable.vue';
import { Button } from '@/components/ui/button';
import { Plus, Search } from 'lucide-vue-next';
import Filter from './{{ $config->modelNames->snakePlural }}/Filter.vue';
const { t } = useI18n();
const page = usePage();
const can = (page.props.can as Record<string, boolean>);

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: t('{{ $config->modelNames->humanPlural }}'),
        href: '/{{ $config->modelNames->dashedPlural }}',
    },
]);

const openFilterModal = ref(false);
const datatableRef = ref();

// Função para aplicar filtros
const applyFilters = (data: any) => {
    if (datatableRef.value && datatableRef.value.table) {
        datatableRef.value.filterData = data;
        datatableRef.value.table.dt.ajax.reload();
    }
    openFilterModal.value = false;
};
</script>
    
<template>
    <Head :title="t('{{ $config->modelNames->humanPlural }}')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <Filter v-model:open="openFilterModal" @apply-filters="applyFilters" />

        <div class="p-4 sm:p-6 md:p-8 w-full">
            <Datatable ref="datatableRef">
                <template v-slot:toolbar>
                    <Link href="/{{ $config->modelNames->dashedPlural }}/create" v-if="can['{{ $config->modelNames->snakePlural }}.create']">
                        <Button class="mr-2 mb-2">
                            <Plus />@verbatim {{ t('New') }} @endverbatim
                        </Button>
                    </Link>
                    <Button @click="openFilterModal = true">
                        <Search /> @verbatim {{ t('Filter') }} @endverbatim
                    </Button>
                </template>
            </Datatable>
        </div>
    </AppLayout>
</template>
    