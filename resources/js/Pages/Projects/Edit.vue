<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('projects')">
                    Projects
                </inertia-link>
                <span class="pl-10">Settings of <b>{{ project.name }}</b></span>
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="permissions.canUpdateProject">
            <update-project-form :project="project" :exampleRepository="exampleRepository" :integrationTypes="integrationTypes" />
        </div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="permissions.canDeleteProject">
            <delete-project-form :project="project" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeleteProjectForm from "./DeleteProjectForm";
import UpdateProjectForm from "./UpdateProjectForm";

export default {
    components: {
        AppLayout,
        DeleteProjectForm,
        UpdateProjectForm,
    },

    props: [
        'permissions',
        'project',
        'exampleRepository',
        'integrationTypes',
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
