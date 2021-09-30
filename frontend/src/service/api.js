import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8083'
})

export default api;