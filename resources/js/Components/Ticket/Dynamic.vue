<template>
    <TicketLayout class="p-2">
        <h1 as="h6" class="text-start font-bold">{{ ticket.title }}</h1>
        <p class="text-gray-700">{{ ticket.description }}</p>
    </TicketLayout>
</template>

<script setup>
import TicketLayout from './Layout.vue';
const props = defineProps({
    ticket: Object
});
</script>
