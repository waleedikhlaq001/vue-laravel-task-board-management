<template>
    <TicketLayout class="border-none shadow-none">
      <form @submit.prevent="addTicket" class="flex flex-col gap-2">
          <label for="" class="-mb-2 text-gray-600 text-sm">Title:</label>
          <input type="text" placeholder="Ticket title" name="ticket_title" v-model="ticketForm.title" class="input" />
          <label for="" class="-mb-2 text-gray-600 text-sm">Start Date: </label>
          <input type="date" v-model="ticketForm.start_date" placeholder="Start Date" class="input" />
          <label for="" class="-mb-2 text-gray-600 text-sm">End Date: </label>
          <input type="date" v-model="ticketForm.end_date" placeholder="End Date" class="input" />
          <label for="" class="-mb-2 text-gray-600 text-sm">Description: </label>
          <input type="textarea" placeholder="Description" name="ticket_description" v-model="ticketForm.description" class="input" />
          <Button variant="secondary" >Add</Button>
      </form>
    </TicketLayout>
</template>

<script setup>
import { reactive } from 'vue';
import Button from '../Form/Button.vue';
import TicketLayout from './Layout.vue';
import axios from 'axios';

  const props = defineProps({
      board: Object
  });

  const ticketForm = reactive({
      title: '',
      description: '',
      start_date: '',
      end_date: '',
      board_id: props.board.id
  });

  const addTicket = async () => {
                  ticketForm.board_id = props.board.id;
                  const ranke = props.board?.tickets?.length + 1 || 1;
                  try{
                      const response = axios.post('/ticket',{
                                                ...ticketForm,
                                                ranke
                                            } );
                      window.location.reload();
                  } catch(error) {
                    console.log('ticket create error ', error);
                  }
  }
  </script>
