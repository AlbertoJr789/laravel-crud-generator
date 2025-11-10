<script setup lang="ts">
   import { useI18n } from 'vue-i18n';
   import { {{ $config->modelNames->name }} } from '@/types';
   import { Checkbox } from '@/components/ui/checkbox';
   import { Label } from '@/components/ui/label';
   
   const { t } = useI18n();
   
   const props = defineProps<{
       form: {{ $config->modelNames->name }};
   }>();
   
   </script>
   
   <template>
       <div class="space-y-4">
           @verbatim <h3 class="text-lg font-semibold">{{ t('Registration Summary') }}</h3> @endverbatim
           
           <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-muted/50 rounded-lg">
            @foreach($config->fields as $field) 
                @php 
                    if(in_array($field->name, ['id', 'active', 'created_at', 'updated_at', 'deleted_at', 'creator_id', 'editor_id', 'deleter_id'])) continue;
                    $fieldName = "<p class=\"text-sm text-muted-foreground\">{{ t('{$field->name}') }}</p>";
                    $fieldValue = "<p class=\"font-medium\">{{ form.{$field->name} }}</p>";
                @endphp
               <div>
                   {!! $fieldName !!}
                   {!! $fieldValue !!}
               </div>
            @endforeach
           </div>
       </div>
       @verbatim
       <div class="space-y-2">
           <div class="flex items-center space-x-2">
               <Checkbox id="active" v-model="form.active" />
               <Label for="active" class="font-normal cursor-pointer">
                   {{ t('Register as Active') }}
               </Label>
           </div>
       </div>
       @endverbatim
   </template>