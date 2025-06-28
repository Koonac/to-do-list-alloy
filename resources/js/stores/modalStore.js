import { defineStore } from "pinia";
import { ref } from "vue";

export const useModalStore = defineStore("modal", () => {
    const showTaskModal = ref(false);
    const editingTask = ref(null);

    function openTaskModal(task = null) {
        editingTask.value = task;
        showTaskModal.value = true;
    }

    function closeTaskModal() {
        editingTask.value = null;
        showTaskModal.value = false;
    }

    return {
        showTaskModal,
        editingTask,
        openTaskModal,
        closeTaskModal,
    };
});
