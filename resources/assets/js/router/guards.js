import Flash from '@/util/Flash';
import store from '@/store';

export const auth = (to, from, next) => {
    if (store.getters.auth.guest) {
        window.storage.set('url.intended', to.fullPath);
        Flash.show('You must sign in to view this page.', 'warning');
        next('/signin');
    }

    next();
};

export const guest = (to, from, next) => {
    if (store.getters.auth.check) {
        Flash.show('You are already signed in.', 'info');
        next('/');
    }

    next();
};
