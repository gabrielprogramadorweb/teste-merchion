import api from './api';
import { Task } from '../models/Task';

export const getTasks = () => api.get<Task[]>('/tasks');
export const createTask = (task: Task) => api.post('/tasks', task);
export const updateTask = (task: Task) => api.put(`/tasks/${task.id}`, task);
export const deleteTask = (id: number) => api.delete(`/tasks/${id}`);
