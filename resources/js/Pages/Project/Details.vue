<template>
     <Head title="Project Board" />

<AuthenticatedLayout>
    <div class="flex flex-col mx-5">
      <h1 class="text-start font-bold text-2xl">{{ project.title }}</h1>
      <p class="text-gray-500">{{ project.description }}</p>
      <div class="mt-4">
          <Button variant="primary" @click.prevent="showBoard = !showBoard">Add Board</Button>
      </div>

      <div class="w-full flex gap-2 overflow-x-auto mt-3">
          <BoardStatic v-if="showBoard" :project="project"></BoardStatic>
          <BoardDynamic v-for="board in project.boards" :key="board.id" :board="board" />
      </div>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import BoardStatic from '@/Components/Project/BoardStatic.vue';
import BoardDynamic from '@/Components/Board/BoardDynamic.vue';
import Button from '@/Components/Form/Button.vue';

const props = defineProps(['project']);

  const showBoard = ref(false);
  onMounted(() => {
//   console.log('Component mounted with Project ID:', projectId);
});
  </script>

  <style>

  </style>
