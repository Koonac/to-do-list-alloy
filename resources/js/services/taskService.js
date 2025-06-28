import axios from "axios";

const api = axios.create({
    baseURL: "/api",
});

export default {
    getAll: () => api.get("/tasks"),
    get: (id) => api.get(`/tasks/${id}`),
    create: (data) => api.post("/tasks", data),
    update: (id, data) => api.put(`/tasks/${id}`, data),
    remove: (id) => api.delete(`/tasks/${id}`),
    toggle: (id) => api.patch(`/tasks/${id}/toggle`),
};
