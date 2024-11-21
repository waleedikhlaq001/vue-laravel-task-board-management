<template>
    <BoardLayout ref="boardContainer" class="overflow-y-auto ">
          <h1 class="flex justify-between items-center font-extrabold text-2xl sticky top-0 bg-gray-100 p-2">
              <span class="font-extrabold text-2xl">{{ props.board.title }}</span>

                <div class="flex gap-3">
                    <PlusCircleIcon class="size-6 cursor-pointer stroke-green-400" @click.prevent="toggleTicketForm"></PlusCircleIcon>
                    <TrashIcon class="size-5 cursor-pointer stroke-rose-400" @click.prevent="deleteBoard(props.board.id)"></TrashIcon>
                </div>
          </h1>

          <div class="flex flex-col gap-3 p-2">
              <TicketStatic :board="board" v-if="showTicketFrom" />
              <Draggable
                          group="board"
                          v-model="props.board.tickets"
                          @change="handleChange"
                          class="flex flex-col gap-3 min-h-60"
                          :itemKey="`${props.board.id}`"
                  >
                  <template #item="{ element }">
                      <TicketDynamic :ticket="element" />
                  </template>
              </Draggable>
          </div>
    </BoardLayout>
</template>

<script setup>
  import { PlusCircleIcon, TrashIcon } from '@heroicons/vue/24/outline';
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
  const boardContainer = ref(null);

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

  const deleteBoard = async (id) => {
        try{
            const response = await axios.delete(`/board/${id}`);
            console.log('delete board done', response);
            window.location.reload();
        } catch(error) {
            console.log('delete board error ', error);
        }
  }

  const toggleTicketForm = () => {
    showTicketFrom.value = !showTicketFrom.value;

    boardContainer.value.$el.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

  <style>

  </style>
