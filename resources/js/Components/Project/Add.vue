<template>
    <div class="flex flex-col">
        <div class="flex md:flex-row flex-col md:items-center md:justify-between">
          <Button variant="primary" @click="showForm = !showForm">Add Project</Button>
        </div>
        <Modal :show="showForm" @close="showForm = false">
            <div class="p-3">
                <h1 class="font-bold text-2xl">Add Project</h1>

                <InputLabel class="mt-3">Title:</InputLabel>
                <TextInput v-model="project.title" class="w-full"></TextInput>

                <InputLabel class="mt-3">Description: </InputLabel>
                <textarea v-model="project.description" class="w-full border-gray-300 rounded"></textarea>

                <div class="flex justify-end gap-3">
                    <Button
                            class="w-40 md:mt-5 text-purple-800 border border-purple-800 font-bold"
                            variant="ghost"
                            @click.prevent="showForm = false"
                        >
                        Cancel
                    </Button>
                    <Button
                            class="w-40 md:mt-5 font-bold"
                            variant="primary"
                            @click.prevent="addProject"
                        >
                        Save
                    </Button>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import axios from 'axios';
import Button from '../Form/Button.vue';
import { reactive, ref } from 'vue';
import Modal from '../Modal.vue';
import TextInput from '../TextInput.vue';
import InputLabel from '../InputLabel.vue';

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
