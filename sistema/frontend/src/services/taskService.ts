import axios from 'axios';
import { Task } from '../models/Task';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true
});

export const getTasks = () => api.get<Task[]>('/tasks');
export const getTask = (id: number) => api.get<Task>(`/tasks/${id}`);
export const createTask = (task: Task) => api.post('/tasks', task);
export const updateTask = (task: Task) => api.put(`/tasks/${task.id}`, task);
export const deleteTask = (id: number) => api.delete(`/tasks/${id}`);
