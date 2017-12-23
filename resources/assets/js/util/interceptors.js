import Flash from './Flash';
import axios from 'axios';

const request = [
    (config) => {
        if (window.store.has('auth.token')) {
            config.headers.common['Authorization'] = `Bearer ${window.store.get('auth.token')}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
];

const response = [
    (response) => {
        const res = response;
        Flash.emitter(res.data, 'success');

        return response;
    },
    (error) => {
        const res = error.response;
        Flash.emitter(res.data, 'error');

        if (res.data.message === 'jwt_refresh') {
            return new Promise((resolve, reject) => {
                axios.get('/refresh')
                    .then(({ data: { token } }) => {
                        window.store.set('auth.token', token);
                        res.config.headers['Authorization'] = `Bearer ${token}`;
                        resolve(axios(res.config));
                    })
                    .catch((error) => {
                        window.eventBus.$emit('jwt-error', res.config.url);
                        reject(error);
                    });
            });
        } else {
            return Promise.reject(error);
        }
    }
];

export default { request, response };
