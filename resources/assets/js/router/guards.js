import axios from 'axios';
import Flash from '@/util/Flash';

export const auth = (to, from, next) => {
    const redirectGuest = () => {
        window.store.set('url.intended', to.fullPath);
        Flash.show('You must sign in to view this page.', 'warning');
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
                Flash.show('You are already signed in.', 'info');
                next('/');
            })
            .catch(() => next());
    }
};
