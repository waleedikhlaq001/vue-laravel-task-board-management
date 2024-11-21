<template>
    <Head title="Project" />

<AuthenticatedLayout>
    <div class="flex flex-col gap-10 mx-8 mt-3">
    <h1 class="font-bold text-2xl">Your Projects</h1>
    <ProjectAdd />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <ProjectCard v-for="project in projectAll" :key="project.id" :project="project" />
    </div>
  </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProjectCard from '@/Components/Project/ProjectCard.vue';
import ProjectAdd from '@/Components/Project/Add.vue'

const props = defineProps(['projectAll']);
</script>
