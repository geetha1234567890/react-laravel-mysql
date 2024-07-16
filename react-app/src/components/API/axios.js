//import axios from 'axios';

//export default axios.create({
//    baseURL: ''
//});

import axios from 'axios';
import { baseUrl } from '../../../utils/baseURL';  // Import the base URL from your utils

const axiosInstance = axios.create({
    baseURL: baseUrl, // Set the base URL
    timeout: 1000,    // Set a timeout (optional)
//    headers: {        // Set default headers (optional)
//        'Content-Type': 'application/json',
//        'Authorization': 'Bearer YOUR_TOKEN_HERE'
    }
});

export default axiosInstance;
