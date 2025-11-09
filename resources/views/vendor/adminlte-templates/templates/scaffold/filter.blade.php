<script setup lang="ts">
    import Button from '@/components/ui/button/Button.vue';
    import Datepicker from '@/components/ui/Datepicker.vue';
    import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
    import Label from '@/components/ui/label/Label.vue';
    import Select from '@/components/ui/select/Select.vue';
    import SelectContent from '@/components/ui/select/SelectContent.vue';
    import SelectItem from '@/components/ui/select/SelectItem.vue';
    import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
    import SelectValue from '@/components/ui/select/SelectValue.vue';
    import Switch from '@/components/ui/switch/Switch.vue';
    import { ref } from 'vue';
    import { useI18n } from 'vue-i18n';
    import { getStandardFilterData } from './filter';
    
    const { t } = useI18n();
    
    const open = defineModel<boolean>('open', { default: false });
    
    const filterData = ref(getStandardFilterData());
    
    const emit = defineEmits<{
        applyFilters: [data: any]
    }>();
    
    
    function clearFilters(){
        filterData.value = getStandardFilterData();
        apply();
    }
    
    function apply(){
        emit('applyFilters', filterData.value);
    }
    </script>
    
    <template>
        <Dialog v-model:open="open">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>{{ t('Filter') }}</DialogTitle>
                </DialogHeader>
                
                <!-- Aqui você pode adicionar os campos de filtro -->
                <div class="space-y-4">
                    <div>
                        <Label for="dateTypeFilter" class="block text-sm font-medium">{{ t('Data Type') }}</Label>
                        <Select id="dateTypeFilter" v-model="filterData.dateTypeFilter">
                            <SelectTrigger>
                            <SelectValue :placeholder="t('Select a date type')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="C">
                                     {{ t('Creation Date') }}
                                </SelectItem>
                                <SelectItem value="U">
                                     {{ t('Update Date') }}
                                </SelectItem>
                                <SelectItem value="D">
                                     {{ t('Deletion Date') }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                          
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <Label for="initialDate" class="block text-sm font-medium">{{ t('Initial Date') }}</Label>
                            <Datepicker v-model="filterData.initialDate" />
                        </div>
                        <div>
                            <Label for="endDate" class="block text-sm font-medium">{{ t('End Date') }}</Label>
                            <Datepicker v-model="filterData.endDate" />
                        </div>
                    </div>
    
                    <div class="flex items-center space-x-2">
                       <Switch id="activeFilter" v-model="filterData.activeFilter" />
                       <Label for="activeFilter">{{ t('Only active') }}</Label>
                    </div>
    
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <Button 
                        @click="clearFilters" 
                        variant="secondary"
                    >
                        {{ t('Clear') }}
                    </Button>
                    <Button 
                        @click="apply" 
                    >
                        {{ t('Apply Filters') }}
                    </Button>
                </div>
            </DialogContent>
        </Dialog>
    </template>