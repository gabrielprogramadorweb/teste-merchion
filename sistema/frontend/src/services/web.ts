import axios from 'axios';

const web = axios.create({
    baseURL: 'http://localhost:8080',
    withCredentials: true
});

export default web;
