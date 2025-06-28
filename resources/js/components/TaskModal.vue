<script setup>
import { computed } from "vue";
import { useModalStore } from "../stores/modalStore";
import { useTaskStore } from "../stores/taskStore";
import TaskForm from "./TaskForm.vue";

const modalStore = useModalStore();
const taskStore = useTaskStore();

const isEditing = computed(() => !!modalStore.editingTask);

const task = computed(
    () =>
        modalStore.editingTask || {
            nome: "",
            descricao: "",
            data_limite: "",
            finalizado: false,
        }
);

function close() {
    modalStore.closeTaskModal();
}

async function submit(formData) {
    if (isEditing.value) {
        await taskStore.updateTask(modalStore.editingTask.id, formData);
    } else {
        await taskStore.createTask(formData);
    }
    close();
}
</script>
<template>
    <div
        v-if="modalStore.showTaskModal"
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
    >
        <div
            class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md relative"
        >
            <button
                @click="close"
                class="absolute top-5 right-5 text-[40px] text-gray-400 hover:text-gray-600"
            >
                &times;
            </button>

            <h2 class="text-xl font-semibold mb-4">
                {{ isEditing ? "Editar Tarefa" : "Nova Tarefa" }}
            </h2>

            <TaskForm :task="task" @submit="submit" @cancel="close" />
        </div>
    </div>
</template>
