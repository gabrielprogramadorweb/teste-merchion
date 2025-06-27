import axios from 'axios';
import { Task } from '../models/Task';

const API_URL = 'http://localhost:8080/api';

export const getTasks = () => {
    return axios.get<Task[]>(`${API_URL}/tasks`, { withCredentials: true });
};

export const createTask = (task: Task) => {
    return axios.post(`${API_URL}/tasks`, task, { withCredentials: true });
};

export const updateTask = (task: Task) => {
    return axios.put(`${API_URL}/tasks/${task.id}`, task, { withCredentials: true });
};

export const deleteTask = (id: number) => {
    return axios.delete(`${API_URL}/tasks/${id}`, { withCredentials: true });
};
