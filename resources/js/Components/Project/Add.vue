<template>
    <div class="flex flex-col">
        <div class="flex md:flex-row flex-col gap-4 md:items-center md:justify-between">
          <form class="grid grid-cols-1 md:grid-cols-3 gap-2 flex-grow" v-if="showForm">
                <input name="title"  v-model="project.title" placeholder="title" class="input" />
                <input name="description" v-model="project.description" placeholder="Description" class="input" />
                <Button class="w-40 md:mt-5 text-purple-800 font-bold" variant="ghost" @click.prevent="addProject">Save</Button>
          </form>
          <Button variant="primary" @click="showForm = !showForm">Add Project</Button>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import Button from '../Form/Button.vue';
import { reactive, ref } from 'vue';

  const project = reactive({
    title: '',
    description: ''
  });

  const showForm = ref(false);

  const addProject = async () => {
    try{
        const response = await axios.post('/project', project);
        console.log('response ', response);
        window.location.reload();
    } catch(error) {
        console.log('add project error ', error);
    }
  }
  </script>

  <style>

  </style>
