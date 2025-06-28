<script setup>
import { useModalStore } from "../stores/modalStore";
import { useTaskStore } from "../stores/taskStore";

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["edit", "delete"]);

const taskStore = useTaskStore();
const modalStore = useModalStore();

const { toggleTask, deleteTask } = taskStore;

function formatDate(value) {
    if (!value) return "";
    const date = new Date(value);
    return date.toLocaleString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
}
</script>
<template>
    <div
        class="flex items-start justify-between p-4 shadow-sm bg-white hover:shadow-md transition mb-2 hover:bg-gray-100"
        @click.stop="modalStore.openTaskModal(task)"
    >
        <!-- Checkbox + Info -->
        <div class="flex items-start gap-3">
            <input
                type="checkbox"
                :checked="task.finalizado"
                @change.stop="toggleTask(task.id)"
                class="mt-1 accent-green-600 w-5 h-5"
            />
            <div
                :class="{
                    'line-through text-gray-400 opacity-70': task.finalizado,
                }"
            >
                <h3 class="font-semibold text-lg">{{ task.nome }}</h3>
                <p class="text-sm text-gray-600" v-if="task.descricao">
                    {{ task.descricao }}
                </p>
                <p class="text-xs text-gray-500 mt-1" v-if="task.data_limite">
                    Data limite: {{ formatDate(task.data_limite) }}
                </p>
            </div>
        </div>

        <!-- Ações -->
        <div
            class="flex p-2 bg-white hover:bg-gray-100 border rounded gap-2 items-center"
        >
            <button
                @click.stop="deleteTask(task.id)"
                class="text-sm text-black hover:underline"
            >
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    ></path>
                </svg>
            </button>
        </div>
    </div>
</template>
