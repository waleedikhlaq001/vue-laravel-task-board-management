<template>
    <BoardLayout class="p-2 overflow-y-auto ">
          <h1 class="flex justify-between items-center font-extrabold text-2xl">
              <span class="font-extrabold text-2xl">{{ props.board.title }}</span>
              <PlusCircleIcon class="size-6 cursor-pointer stroke-green-400" @click.prevent="showTicketFrom = !showTicketFrom"></PlusCircleIcon>
          </h1>

          <div class="flex flex-col gap-3">
              <TicketStatic :board="board" v-if="showTicketFrom" />
              <Draggable
                          group="board"
                          v-model="props.board.tickets"
                          @change="handleChange"
                          class="flex flex-col gap-3 min-h-60"
                  >
                  <template #item="{ element }">
                      <TicketDynamic :ticket="element" />
                  </template>
              </Draggable>
          </div>
    </BoardLayout>
</template>

<script setup>
  import { PlusCircleIcon } from '@heroicons/vue/24/outline';
  import Draggable from 'vuedraggable';
  import BoardLayout from '@/Components/Board/Layout.vue'
  import TicketStatic from '@/Components/Ticket/Static.vue';
  import TicketDynamic from '@/Components/Ticket/Dynamic.vue'
  import { ref } from 'vue';
import axios from 'axios';

  const props = defineProps({
      board: Object
  });

  const showTicketFrom = ref(false);

 async function handleChange(event) {

 console.log('event tiger', event);

 if(event?.added) {
    const { element, newIndex, oldIndex } = event.added
    try{
        const response = await axios.put(`/ticket/${element.id}`, {new_board_id: props.board.id});
        console.log('ticket move response ', response);
    } catch(error) {
        console.log('ticket move error ', error);
    }
 }

  }
  </script>

  <style>

  </style>
