<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('projects')">
                    Projects
                </inertia-link>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="permissions.canCreateProject">
            <create-project-form :exampleRepository="exampleRepository" :integrations="integrations" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CreateProjectForm from "./CreateProjectForm";

export default {
    components: {
        AppLayout,
        CreateProjectForm,
    },

    props: [
        'permissions',
        'project',
        'exampleRepository',
        'integrations',
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
