<template>
    <TicketLayout class="border-none shadow-none">
      <form @submit.prevent="addTicket" class="flex flex-col gap-2">
          <input type="text" placeholder="Ticket title" name="ticket_title" v-model="ticketForm.title" class="input" />
          <input type="textarea" placeholder="Description" name="ticket_description" v-model="ticketForm.description" class="input" />
          <Button variant="secondary" >Add</Button>
      </form>
    </TicketLayout>
</template>

<script setup>
import { reactive } from 'vue';
import Button from '../Form/Button.vue';
import axios from 'axios';

  const props = defineProps({
      board: Object
  });

  const ticketForm = reactive({
      title: '',
      description: '',
      board_id: props.board.id
  });

  const addTicket = async () => {
                  ticketForm.board_id = props.board.id;
                  const ranke = props.board?.tickets?.length + 1 || 1;
                  try{
                      const response = axios.post('/ticket',{...ticketForm, ranke} );
                      window.location.reload();
                  } catch(error) {
                    console.log('ticket create error ', error);
                  }
  }
  </script>
