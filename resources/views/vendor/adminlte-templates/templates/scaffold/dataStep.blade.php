<script setup lang="ts">
import { {{ $config->modelNames->name }} } from '@/types';
import { useI18n } from 'vue-i18n';

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import Datepicker from '@/components/ui/Datepicker.vue';
import Switch from '@/components/ui/switch/Switch.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';

const { t } = useI18n();

const props = defineProps<{
    form: {{ $config->modelNames->name }};
}>();

</script>

<template>
    {!! $fields !!}
</template>