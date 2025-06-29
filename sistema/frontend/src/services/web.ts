import axios from 'axios';

const web = axios.create({
    baseURL: 'http://localhost:8080',
    withCredentials: true
});

const token = localStorage.getItem('token');
if (token) {
    web.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default web;
