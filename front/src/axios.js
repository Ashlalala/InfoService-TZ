import axios from 'axios';

const backURL = 'http://localhost:8000'; //set your backend url here

const instance = axios.create({
  baseURL: backURL+'/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  }
});

// Function to fetch CSRF cookie
async function fetchCsrfCookie() {
  try {
    await axios.get(backURL+'/sanctum/csrf-cookie', {
      withCredentials: true, // Enable cookies for cross-site requests
    });
  } catch (error) {
    console.error('Error fetching CSRF cookie:', error);
  }
}

instance.interceptors.request.use(async (config) => {
  if (config.method !== 'get') {
    await fetchCsrfCookie(); // Fetch CSRF cookie before sending the request
  }

  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Add a response interceptor
instance.interceptors.response.use(response => {
  return response;
}, error => {
  // Handle errors globally
  if (error.response && error.response.status === 401) {
    // Handle unauthorized access, maybe redirect to login
    // window.location.href = '/login'; // or use Vue Router
  }
  return Promise.reject(error);
});

export default instance;
