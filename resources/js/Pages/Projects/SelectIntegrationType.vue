<template>
    <div>
        <jet-label for="integration_type" value="Integration Type" />
        <jet-form-select  id="integration_type" :options="integrationOptions" v-model="modelValue" autofocus @input="$emit('update:modelValue', $event.target.value)" />
    </div>
</template>

<script>
import JetFormSelect from '@/Jetstream/FormSelect'
import JetLabel from "@/Jetstream/Label";

export default {
    props: [
        'modelValue',
        'integrationTypes',
    ],

    emits: ['update:modelValue'],
    components: {
        JetFormSelect,
        JetLabel,
    },
    data() {
        return {
            integrationOptions: [],
        }
    },
    mounted() {
        this.integrationOptions = this.createIntegrationOptions();
    },
    methods: {
        createIntegrationOptions() {
            if (!this.integrationTypes) {
                return [];
            }
            return this.integrationTypes.map(integrationType => {
                return { value: integrationType, label: integrationType };
            });
        }
    }
}
</script>
