<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { {{ $config->modelNames->name }} } from '@/types';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { watch } from 'vue';

const { t } = useI18n();

const props = defineProps<{
    form: {{ $config->modelNames->name }};
}>();

</script>

<template>
    {!! $fields !!}
</template>