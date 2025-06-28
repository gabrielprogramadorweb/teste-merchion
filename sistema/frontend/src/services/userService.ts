import api from './api';
import type { User } from '@/models/User';

export async function getUserProfile(): Promise<User> {
    const response = await api.get<User>('/user', {
        withCredentials: true
    });
    return response.data;
}

export function updateUserProfile(formData: FormData) {
    return api.post('/perfil/editar', formData, {
        withCredentials: true
    });
}
