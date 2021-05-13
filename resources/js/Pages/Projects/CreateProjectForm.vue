<template>
    <jet-form-section @submitted="createProject">
        <template #title>
            Project Details
        </template>

        <template #description>
            Create a new project.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="repository" value="Project Repository" />
                <jet-input id="repository" type="text" class="mt-1 block w-full" v-model="form.repository" :placeholder="exampleRepository" autofocus />
                <jet-input-error :message="form.errors.repository" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="integration_type" value="Integration Type" />
                <jet-input id="integration_type" disabled type="text" class="mt-1 block w-full" v-model="form.integration_type" autofocus />
                <jet-input-error :message="form.errors.integration_type" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="integration_access_token" value="Integration Access Token" />
                <jet-input id="integration_access_token" type="text" class="mt-1 block w-full" v-model="form.integration_access_token" autofocus />
                <jet-input-error :message="form.errors.integration_access_token" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
    props: ['exampleRepository'],
    components: {
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                repository: '',
                integration_type: 'gitlab',
                integration_access_token: '',
            })
        }
    },

    methods: {
        createProject() {
            this.form.post(route('projects.store'), {
                errorBag: 'createProject',
                preserveScroll: true
            });
        },
    },
}
</script>
