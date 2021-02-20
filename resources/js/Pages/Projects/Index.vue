<template>
    <app-layout>
        <template #header>
            <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-block">
                Projects
            </h2>
            <inertia-link v-if="permissions.canCreateProject" :href="route('projects.create')" class="pl-10 flex items-center">
                <icon-plus-circle class="w-8 h-8"  /> <span class="pl-2">Create</span>
            </inertia-link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" v-if="projects.length">
            <jet-action-section>
                <template #title>
                    <jet-label for="name" value="Projects" />
                </template>
                <template #content>


                    <template v-for="(project, index) in projects" :key="project.id">
                        <jet-section-border v-if="index > 0" />
                        <div class="flex items-center justify-between ">
                            <div class="text-blue-600 text-xl"><inertia-link :href="route('projects.show', project.id)">{{ project.name }}</inertia-link></div>
                            <inertia-link :href="route('projects.edit', project.id)" class="flex items-center" alt="Settings" title="Settings">
                                <icon-pencil-alt class="w-8 h-8"></icon-pencil-alt>
                            </inertia-link>
                        </div>
                    </template>
                </template>
            </jet-action-section>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetActionSection from '@/Jetstream/ActionSection'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import JetLabel from '@/Jetstream/Label'
import CreateProjectForm from './CreateProjectForm'
import IconPlusCircle from '@/Icon/PlusCircle'
import IconPencilAlt from '@/Icon/PencilAlt'

export default {
    props: [
        'permissions',
        'projects',
    ],

    components: {
        AppLayout,
        JetActionSection,
        JetSectionBorder,
        JetLabel,
        CreateProjectForm,
        IconPlusCircle,
        IconPencilAlt,
    },
}
</script>
