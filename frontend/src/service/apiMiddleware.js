import axios from 'axios';

const apiMiddleware = axios.create({
    baseURL: 'http://localhost:8082'
})

export default apiMiddleware;