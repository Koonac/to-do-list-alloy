import { defineStore } from "pinia";
import taskService from "../services/taskService.js";

export const useTaskStore = defineStore("tasks", {
    state: () => ({
        tasks: [],
        loading: false,
    }),

    actions: {
        async fetchTasks() {
            this.loading = true;
            const res = await taskService.getAll();
            this.tasks = res.data.data;
            this.loading = false;
        },

        async createTask(task) {
            await taskService.create(task);
            await this.fetchTasks();
        },

        async updateTask(id, data) {
            await taskService.update(id, data);
            await this.fetchTasks();
        },

        async deleteTask(id) {
            await taskService.remove(id);
            await this.fetchTasks();
        },

        async toggleTask(id) {
            await taskService.toggle(id);
            await this.fetchTasks();
        },
    },
});
