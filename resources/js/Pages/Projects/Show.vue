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
                    <h3 class="pb-10 text-xl">Releases of `{{ project.name }}`</h3>
                    <div v-for="(release, index) in releases">
                        <jet-section-border v-if="index > 0" />
                        <div  class="flex flex-row justify-between">
                            <div class="flex flex-col w-3/4">
                                <h4 class="text-lg text-blue-900 pb-5">{{ release.name }}</h4>
                                <p>{{ release.description }}</p>
                            </div>
                            <div class="flex flex-col  w-1/4">
                                <h3 class="pb-5 text-lg">Packages</h3>
                                <div v-for="artifact in release.packages">
                                    <a :href="artifact.url" class="mb-2 flex items-center"><icon-download></icon-download><span class="ml-2">{{ artifact.name }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
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
import IconDownload from "@/Icon/Download";
import IconPencilAlt from "@/Icon/PencilAlt";
import JetSectionBorder from "@/Jetstream/SectionBorder";

export default {
    components: {
        Button,
        AppLayout,
        JetButton,
        JetSectionBorder,
        JetSecondaryButton,
        JetDangerButton,
        JetActionSection,
        JetConfirmationModal,
        JetInput,
        JetInputError,
        JetLabel,
        IconDownload,
        IconPencilAlt,
    },

    props: [
        'permissions',
        'project',
        'releases',
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
