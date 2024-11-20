<template>
    <BoardLayout>
          <form class="flex flex-col gap-2">
              <div class="flex items-center w-full gap-2 mt-2 px-2">
                  <input v-model="boradForm.title" placeholder="Board Title" class="flex-grow-1 input" />
                  <Button type="submit" variant="secondary" @click.prevent="addBoard">Add</Button>
              </div>
          </form>
    </BoardLayout>
</template>

<script setup>
import BoardLayout from '@/Components/Board/Layout.vue'
import Button from '../Form/Button.vue';
import { reactive } from 'vue';
import axios from 'axios';

  const props = defineProps({
      project: Object
  });

  const boradForm = reactive({
      title: '',
      project_id: props.project.id
  });

  const addBoard = async () => {

    try{
        const response = await axios.post('/board', boradForm);
        console.log('board response done ', response);
        window.location.reload();
    } catch(error){
        console.log('board error ', error);
    }
  }
  </script>

  <style>

  </style>
