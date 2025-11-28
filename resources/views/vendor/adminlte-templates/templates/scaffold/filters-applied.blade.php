<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { clearFilter, formatFilterValue, getFilterNames } from './filter';
import { X } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
const filterNames = getFilterNames();

const { t } = useI18n()

const emit = defineEmits<{
    clearFilter: []
}>()

const props = defineProps({
    filterData: Object,
})

</script>
    
<template>
    <div
    v-if="filterData && Object.keys(filterData).length"
    class="mb-4 flex flex-wrap items-center gap-2 justify-between"
    >
        <div class="flex flex-wrap gap-2">
            <template v-for="(value, key) in filterData" :key="key">
                <span
                    v-if="value !== undefined && value !== null && value !== ''"
                    class="inline-flex items-center border border-gray-400 bg-transparent px-3 py-1 rounded-md text-sm font-medium "
                >
                    <strong class="mr-1">@{{ t(filterNames[key as keyof typeof filterNames]) }}:</strong>
                    <span class="mr-2">@{{ t(formatFilterValue(key, value)) }}</span>
                    <Button
                        size="sm"
                        variant="outline"
                        class="h-5 w-2"
                        @@click="clearFilter(filterData,key); emit('clearFilter');"
                    ><X /></Button>
                </span>
            </template>
        </div>
    </div>
</template>