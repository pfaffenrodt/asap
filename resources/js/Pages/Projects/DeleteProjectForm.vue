<template>
    <jet-action-section>
        <template #title>
            Delete Project
        </template>

        <template #description>
            Permanently delete this project.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once a project is deleted, all of its resources and data will be permanently deleted. Before deleting this project, please download any data or information regarding this project that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmProjectDeletion">
                    Delete Project
                </jet-danger-button>
            </div>

            <!-- Delete Project Confirmation Modal -->
            <jet-confirmation-modal :show="confirmingProjectDeletion" @close="confirmingProjectDeletion = false">
                <template #title>
                    Delete Project
                </template>

                <template #content>
                    Are you sure you want to delete this project? Once a project is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingProjectDeletion = false">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteProject" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Project
                    </jet-danger-button>
                </template>
            </jet-confirmation-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        props: ['project'],

        components: {
            JetActionSection,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingProjectDeletion: false,
                deleting: false,

                form: this.$inertia.form()
            }
        },

        methods: {
            confirmProjectDeletion() {
                this.confirmingProjectDeletion = true
            },

            deleteProject() {
                this.form.delete(route('projects.destroy', this.project), {
                    errorBag: 'deleteProject'
                });
            },
        },
    }
</script>
