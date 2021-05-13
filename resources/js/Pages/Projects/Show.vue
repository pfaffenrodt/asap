<template>
    <app-layout>
        <template #header>
            <div class="flex items-center text-xl text-gray-800 leading-tight">
                <h2 class="font-semibold  inline-block">

                    <inertia-link :href="route('projects')">
                        Projects
                    </inertia-link>
                </h2>
                <inertia-link :href="route('projects.edit', project.id)" class="flex items-center" alt="Edit" title="Edit">
                    <b class="font-semibold pl-10 pr-2">{{ project.name }}</b>
                    <icon-pencil-alt class="w-8 h-8"></icon-pencil-alt>
                </inertia-link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-action-section @submitted="createProject">
                <template #title>

                </template>

                <template #description>
                </template>

                <template #content>
                    TODO show details of project {{ project.name }}
                </template>

            </jet-action-section>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetActionSection from '@/Jetstream/ActionSection'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import Button from "@/Jetstream/Button";
import IconPlusCircle from "@/Icon/PlusCircle";
import IconPencilAlt from "@/Icon/PencilAlt";

export default {
    components: {
        Button,
        AppLayout,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        JetActionSection,
        JetConfirmationModal,
        JetInput,
        JetInputError,
        JetLabel,
        IconPencilAlt,
    },

    props: [
        'permissions',
        'project',
    ],
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
            this.form.delete(route('projects.delete', this.project.id), {
                errorBag: 'deleteProject',
                preserveScroll: true
            });
        },
    },

}
</script>
