<template>
    <TicketLayout class="p-2">
        <div class="flex justify-between">
            <h1 as="h6" class="text-start font-bold">{{ ticket.title }}</h1>
            <div class="flex gap-3">
                <PencilSquareIcon class="size-4 text-gray-500 cursor-pointer" @click.prevent="editTicketFun(ticket)"></PencilSquareIcon>
                <TrashIcon @click.prevent="deleteTicket(ticket.id)" class="size-4 text-rose-500 cursor-pointer"></TrashIcon>
            </div>
        </div>
        <p class="text-gray-700">{{ ticket.description }}</p>

        <Modal :show="showTicketModal" @close="showTicketModal = false">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Edit Ticket</h1>

                <InputLabel class="mt-3">Title:</InputLabel>
                <TextInput v-model="editTicket.title" class="w-full" />

                <InputLabel class="mt-2">Description:</InputLabel>
                <textarea v-model="editTicket.description" class="w-full rounded border-gray-300" ></textarea>

                <div class="flex justify-end gap-3 mt-3">
                    <SecondaryButton @click.prevent="showTicketModal = false">Cancel</SecondaryButton>
                    <PrimaryButton @click.prevent="updateTicket" class="">Update</PrimaryButton>
                </div>
            </div>
    </Modal>
    </TicketLayout>
</template>

<script setup>
import { ref } from 'vue';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import TicketLayout from './Layout.vue';
import Modal from '../Modal.vue';
import InputLabel from '../InputLabel.vue';
import TextInput from '../TextInput.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import axios from 'axios';

const props = defineProps({
    ticket: Object
});

const showTicketModal = ref(false);
const editTicket = ref({});

const editTicketFun = (item) => {
    editTicket.value = item;
    showTicketModal.value = true;
}

const updateTicket = async () => {
    try {
        const response = await axios.put(`/ticket/update/${editTicket.value.id}`, editTicket.value);
        console.log('ticket update ', response);
        showTicketModal.value = false;
    } catch(error) {
        console.log('update ticket error ', error);
    }
}

const deleteTicket = async (id) => {
    try{
        const response = await axios.delete(`/ticket/${id}`);
        window.location.reload();
        console.log('ticket delete done', response);
    } catch(error) {
        console.log('ticket delete error ', error);
    }
}
</script>
