<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Person, type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed, onMounted, ref } from 'vue';
import { Stepper, StepperItem, StepperTrigger, StepperTitle, StepperDescription, StepperSeparator } from '@/components/ui/stepper';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

import { Check, ListChecks, Info } from 'lucide-vue-next';
import SubmitButton from '@/components/ui/button/SubmitButton.vue';
import { toast } from 'vue-sonner';
import DataStep from './steps/DataStep.vue';
import SummaryStep from './steps/SummaryStep.vue';

const { t } = useI18n();

const props = defineProps<{
    {{ $config->modelNames->name }}: {{ $config->modelNames->name }} | null;
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: t('{{ $config->modelNames->name }}'),
        href: '/{{ $config->modelNames->dashedPlural }}',
    },
    {
        title: t('Create {{ $config->modelNames->name }}'),
        href: '/{{ $config->modelNames->dashedPlural }}/create',
    },
]);

const steps = [
    {
        step: 1,
        title: t('{{ $config->modelNames->human }} Data'),
        description: t('Basic Information'),
        icon: Info,
    },
    {
        step: 2,
        title: t('Finish'),
        description: t('Complete Registration'),
        icon: ListChecks,
    },
]

const stepIndex = ref(1);

const form = useForm<{{ $config->modelNames->name }}>({
    @foreach($config->fields as $field)
        {{ $field->name }}: '',
    @endforeach
});

const validateStep1 = (): boolean => {
    return true
};

const enabledStep = (step: number) => {
    let result = false;
    switch (step) {
        case 1:
                result = true
                break;
        case 2:
            result = validateStep1();
            break;
    }
    return result;
};

const canProceed = computed(() => (step: number) => {
    return enabledStep(step);
});

const allStepsCompleted = computed(() => {
    return steps.every((step) => enabledStep(step.step));
});

const submit = () => {
    if(props.{{ $config->modelNames->name }}?.id){
        form.patch(`/{{ $config->modelNames->dashedPlural }}/${props.{{ $config->modelNames->name }}.id}`, {
            preserveScroll: true,
            headers: {
                accept: 'application/json'
            },
            onSuccess: () => {
                toast.success(t('{{ $config->modelNames->name }} updated successfully'), {
                    position: 'top-right',
                });
                setTimeout(() => {
                    router.visit('/{{ $config->modelNames->dashedPlural }}');
                }, 1000);
            },
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();
                const errorMessage = errorMessages.length > 0 ? errorMessages.join(', ') : '';
                toast.error(t('Error while updating {slug}', { slug: t('{{ $config->modelNames->name }}').toLowerCase() }), {
                    position: 'top-right', 
                    description: errorMessage,
                });
            },
        });
    }else{
        form.post('/{{ $config->modelNames->dashedPlural }}', {
            preserveScroll: true,
            headers: {
                accept: 'application/json'
            },
            onSuccess: () => {
                toast.success(t('{{ $config->modelNames->name }} created successfully'), {
                    position: 'top-right',
                });
                setTimeout(() => {
                    router.visit('/{{ $config->modelNames->dashedPlural }}');
                }, 1000);
            },
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();
                const errorMessage = errorMessages.length > 0 ? errorMessages.join(', ') : '';
                toast.error(t('Error while creating {slug}', { slug: t('{{ $config->modelNames->name }}').toLowerCase() }), {
                    position: 'top-right', 
                    description: errorMessage,
                });
            },
        });
    }
};

onMounted(() => {
    if(props.{{ $config->modelNames->name }}){
        @foreach($config->fields as $field)
            form.{{ $field->name }} = props.{{ $config->modelNames->name }}.{{ $field->name }};
        @endforeach
    }
});

</script>

<template>
    @php
        $head = "<Head :title=\"t('Create {$config->modelNames->human}')\" />";
        $cardTitle = "<CardTitle>{{ t('Create {$config->modelNames->human}') }} </CardTitle>";
        $cardDescription = "<CardDescription>{{ t('Fill in the information to register a new {$config->modelNames->human}')  }}</CardDescription>";
    @endphp
    {!! $head !!}

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 md:p-8 w-full max-w-4xl mx-auto">
            <Card>
                <CardHeader>
                    {!! $cardTitle !!}
                    {!! $cardDescription !!}
                </CardHeader>

                <CardContent>
                    <form @submit.prevent="submit">
                        <Stepper class="block" v-slot="{ nextStep, prevStep, isNextDisabled, isPrevDisabled, isLastStep }" v-model="stepIndex" :linear="allStepsCompleted ? false : true"> 
                            
                            <div class="flex w-full items-start gap-2 mb-6">
                                <StepperItem
                                    v-for="step in steps"
                                    :key="step.step"
                                    v-slot="{ state }"
                                    :disabled="!enabledStep(step.step)"
                                    class="relative flex w-full flex-col items-center justify-center"
                                    :step="step.step"
                                >
                                    <StepperSeparator
                                        v-if="step.step !== steps[steps.length - 1].step"
                                        class="absolute left-[calc(50%+28px)] top-5 -translate-y-1/2 h-0.5 w-[calc(100%-44px)] rounded-full bg-muted group-data-[state=completed]:bg-primary"
                                    />
                                    
                                    <StepperTrigger as-child>
                                        <Button
                                        :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
                                        size="icon"
                                        class="z-10 rounded-full shrink-0 opacity-100"
                                        :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                                        >
                                            <Check v-if="state === 'completed'" class="size-5" />
                                            <component :is="step.icon" v-else />
                                        </Button>
                                    </StepperTrigger>
                                    @verbatim
                                    <div class="flex flex-col items-center text-center">
                                        <StepperTitle
                                        :class="[state === 'active' && 'text-primary']"
                                        class="text-sm font-semibold transition lg:text-base"
                                        >
                                        {{ step.title }}
                                        </StepperTitle>
                                        <StepperDescription
                                        :class="[state === 'active' && 'text-primary']"
                                        class="sr-only text-xs text-muted-foreground transition md:not-sr-only lg:text-sm"
                                        >
                                        {{ step.description }}
                                        </StepperDescription>
                                    </div>
                                    @endverbatim
                                </StepperItem>
                            </div>
                            @verbatim
                            <!-- Step 1: Data  -->
                            <div v-if="stepIndex === 1" class="space-y-6">
                                <DataStep :form="form" />
                            </div>
        
                            <!-- Step 2: Summary -->
                            <div v-if="stepIndex === 2" class="space-y-6">
                                <SummaryStep :form="form" />
                            </div>
                            @endverbatim
                            @verbatim
                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8">
                                
                                <Button variant="outline" :disabled="isPrevDisabled" @click="prevStep" type="button">
                                    {{ t('Back') }}
                                </Button>
        
                                <Button v-if="!isLastStep" :disabled="!canProceed(stepIndex + 1)" @click="nextStep" type="button">
                                    {{ t('Next') }}
                                </Button>
        
                                <SubmitButton v-else :processing="form.processing">
                                    {{ t('Save') }}
                                </SubmitButton>
                            </div>
                            @endverbatim
                        </Stepper>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
