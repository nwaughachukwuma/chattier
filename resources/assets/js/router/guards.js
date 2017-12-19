import axios from 'axios';
import iziToast from 'izitoast';

export const auth = (to, from, next) => {
    const redirectGuest = () => {
        window.store.set('url.intended', to.fullPath);
        iziToast.info({ message: 'You must sign in to view this page.' });
        next('/signin');
    };

    if (!window.store.has('auth.token')) {
        redirectGuest();
    } else {
        axios.get('/check')
            .then(() => next())
            .catch(() => redirectGuest());
    }
};

export const guest = (to, from, next) => {
    if (!window.store.has('auth.token')) {
        next();
    } else {
        axios.get('/check')
            .then(() => {
                iziToast.info({ message: 'You are already signed in.' });
                next('/');
            })
            .catch(() => next());
    }
};
