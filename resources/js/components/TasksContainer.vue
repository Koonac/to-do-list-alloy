<script setup>
import TaskModal from "./TaskModal.vue";
import TaskList from "./TaskList.vue";
</script>

<template>
    <div class="tasks">
        <TaskModal :show="showModal" @close="showModal = false" />
        <TaskList />
    </div>
</template>
