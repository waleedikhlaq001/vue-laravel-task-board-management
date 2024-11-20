<template>
    <div>
        <Link :href="`/project/${project.id}`" class="flex flex-col gap-2 p-2 rounded-lg shadow" >
            <h1 class="text-start flex items-center justify-between font-bold">
                <span>{{ project.title }}</span>
                <div class="flex gap-3">
                    <PencilSquareIcon @click.prevent="editProjectFun(project)" class="size-5 text-gray-600"></PencilSquareIcon>
                    <TrashIcon @click.prevent="deleteProject(project.id)" class="size-5 text-red-600"></TrashIcon>
                </div>
            </h1>
            <p class="text-gray-600">{{ project.description }}</p>
        </Link>

        <Modal :show="showEditProject" @close="showEditProject = false">
            <div class="p-4">
                <h1 class="mb-3 font-bold text-2xl">Edit Project</h1>
                <InputLabel>Title:</InputLabel>
                <TextInput v-model="editProject.title" class="w-full" />

                <InputLabel class="mt-2">Description:</InputLabel>
                <textarea v-model="editProject.description" class="w-full rounded border-gray-300" ></textarea>

                <div class="flex justify-end">
                    <PrimaryButton @click.prevent="updateProject" class="mt-3">Update</PrimaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
  import { TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
  import { Head, Link } from '@inertiajs/vue3';
  import { ref } from 'vue';
import axios from 'axios';
import Modal from '../Modal.vue';
import TextInput from '../TextInput.vue';
import InputLabel from '../InputLabel.vue';
import PrimaryButton from '../PrimaryButton.vue';

  const props = defineProps({
      project: {
          type: Object,
      }
  });

  const editProject = ref({});
  const showEditProject = ref(false);

  const editProjectFun = (item) => {
        editProject.value = item;
        showEditProject.value = true;
  }

  const updateProject = async () => {
        try {
            const response = await axios.put(`/project/${editProject.value.id}`, editProject.value);
            showEditProject.value = false;
            window.location.reload();
        } catch(error) {
            console.log('update project error', error);
        }
  }

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
