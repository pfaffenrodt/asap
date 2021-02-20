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

    export default {
        props: ['project'],

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
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: this.project.name,
                })
            }
        },

        methods: {
            updateProject() {
                this.form.put(route('projects.update', this.project), {
                    errorBag: 'updateProject'
                });
            },
        },
    }
</script>
