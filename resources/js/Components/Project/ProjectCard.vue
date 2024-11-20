<template>
    <div>
        <Link :href="`/project/${project.id}`" class="flex flex-col gap-2 p-2 rounded-lg shadow" >
            <h1 as="h6" class="text-start flex items-center justify-between font-bold">
                <span>{{ project.title }}</span>
                <TrashIcon @click.prevent="deleteProject(project.id)" class="size-5 text-red-600"></TrashIcon>
            </h1>
            <p class="text-gray-600">{{ project.description }}</p>
        </Link>
    </div>
</template>

<script setup>
  import { TrashIcon } from '@heroicons/vue/24/outline';
  import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';

  const props = defineProps({
      project: {
          type: Object,
      }
  });

  const deleteProject = async (id) => {
        try{
            const response = await axios.delete(`/project/${id}`);
            console.log('project deleted done ', response);
            window.location.reload();
        } catch(error) {
            console.log('delete project error ', error);
        }
  }
</script>

  <style>

  </style>
