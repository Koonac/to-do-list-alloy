<script setup>
import TaskItem from "./TaskItem.vue";
import { useTaskStore } from "../stores/taskStore";
import { onMounted } from "vue";

const taskStore = useTaskStore();

const { fetchTasks } = taskStore;

onMounted(() => fetchTasks());
</script>

<template>
    <div class="space-y-2">
        <!-- Skeletons -->
        <template v-if="taskStore.loading">
            <div
                v-for="n in 3"
                :key="n"
                class="animate-pulse flex justify-between items-start p-4 bg-gray-100 rounded"
            >
                <div class="flex gap-3">
                    <div class="w-5 h-5 bg-gray-300 rounded"></div>
                    <div>
                        <div class="h-4 bg-gray-300 rounded w-48 mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-32"></div>
                    </div>
                </div>
                <div class="space-x-2">
                    <div
                        class="h-4 w-12 bg-gray-300 rounded inline-block"
                    ></div>
                    <div
                        class="h-4 w-12 bg-gray-300 rounded inline-block"
                    ></div>
                </div>
            </div>
        </template>

        <!-- Lista de tarefas -->
        <template v-else-if="taskStore.tasks.length > 0">
            <TaskItem
                v-for="task in taskStore.tasks"
                :key="task.id"
                :task="task"
            />
        </template>

        <!-- Nenhuma tarefa -->
        <template v-else>
            <div class="text-center text-gray-500 p-6 italic">
                Nenhuma tarefa encontrada.
            </div>
        </template>
    </div>
</template>
