<script setup>
import { reactive, toRefs } from "vue";
import { watch, defineProps, defineEmits } from "vue";

function formatDate(value) {
    if (!value) return "";
    const date = new Date(value);
    const pad = (n) => n.toString().padStart(2, "0");
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(
        date.getDate()
    )}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

const props = defineProps({
    task: {
        type: Object,
        default: () => ({
            nome: "",
            descricao: "",
            data_limite: "",
            finalizado: false,
        }),
    },
});

const emit = defineEmits(["submit", "cancel"]);

const form = reactive({
    nome: props.task.nome || "",
    descricao: props.task.descricao || "",
    data_limite: formatDate(props.task.data_limite),
    finalizado: props.task.finalizado || false,
});

watch(
    () => props.task,
    (newTask) => {
        Object.assign(form, newTask);
    }
);

function handleSubmit() {
    if (!form.nome.trim()) {
        alert("O nome é obrigatório.");
        return;
    }
    emit("submit", { ...form });
}
</script>
<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
            <label for="nome" class="block font-semibold mb-1"
                >Nome<span class="text-red-500">*</span></label
            >
            <input
                id="nome"
                v-model="form.nome"
                type="text"
                required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Nome da tarefa"
            />
        </div>

        <div>
            <label for="descricao" class="block font-semibold mb-1"
                >Descrição</label
            >
            <textarea
                id="descricao"
                v-model="form.descricao"
                rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Descrição detalhada (opcional)"
            ></textarea>
        </div>

        <div>
            <label for="data_limite" class="block font-semibold mb-1">
                Data Limite
            </label>
            {{ form.data_limite }}
            <input
                id="data_limite"
                v-model="form.data_limite"
                type="datetime-local"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>

        <div class="flex justify-end space-x-2">
            <button
                type="button"
                @click="$emit('cancel')"
                class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100"
            >
                Cancelar
            </button>
            <button
                type="submit"
                class="px-4 py-2 rounded bg-[#1fb76c] text-white hover:bg-[#1fb76c]/80 transition-all"
            >
                Salvar
            </button>
        </div>
    </form>
</template>
