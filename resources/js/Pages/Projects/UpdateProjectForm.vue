<template>
    <jet-form-section @submitted="updateProject">
        <template #title>
            Edit
        </template>

        <template #description>
            Update this project.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Project Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-8 sm:col-span-8">
                <jet-label for="repository" value="Project Repository" />
                <jet-input id="repository" type="text" class="mt-1 block w-full" v-model="form.repository" :placeholder="exampleRepository" autofocus />
                <jet-input-error :message="form.errors.repository" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <select-integration-type class="mt-1 block w-full" :integrations="integrations" v-model="form.integration_type" />
                <jet-input-error :message="form.errors.integration_type" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="integration_access_token" value="Integration Access Token" />
                <jet-input id="integration_access_token" type="text" class="mt-1 block w-full" v-model="form.integration_access_token" :placeholder="integrationAccessTokenPlaceholder" autofocus />
                <jet-input-error :message="form.errors.integration_access_token" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetButton from "@/Jetstream/Button";
    import JetFormSection from "@/Jetstream/FormSection";
    import JetInput from "@/Jetstream/Input";
    import JetInputError from "@/Jetstream/InputError";
    import JetLabel from "@/Jetstream/Label";
    import JetFormSelect from "@/Jetstream/FormSelect";
    import SelectIntegrationType from "@/Pages/Projects/SelectIntegrationType";

    export default {
        props: [
            'project',
            'exampleRepository',
            'integrations',
        ],

        components: {
            JetButton,
            JetActionSection,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetFormSelect,
            SelectIntegrationType,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: this.project.name,
                    repository: this.project.repository,
                    integration_type: this.project.integration_type,
                    integration_access_token: this.project.integration_access_token,
                }),
                exampleRepository: this.exampleRepository,
            }
        },

        methods: {
            updateProject() {
                this.form.put(route('projects.update', this.project), {
                    errorBag: 'updateProject'
                });
            },
        },
        computed: {
            integrationAccessTokenPlaceholder() {
                if (this.project.has_integration_access_token) {
                    return '***';
                }
                return ''
            }
        }
    }
</script>
