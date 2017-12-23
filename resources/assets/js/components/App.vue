<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="container content">
                <app-view></app-view>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from './Navbar';
import Flash from '@/util/Flash';
import iziToast from 'izitoast';

export default {
    components: { Navbar },
    methods: {
        fetchAuthUser () {
            if (window.store.has('auth.token')) {
                this.$http.get('/user')
                    .then((response) => this.$store.commit('setUser', response.data))
                    .catch((error) => console.log(error.response));
            }
        },
        jwtErrorListener () {
            window.eventBus.$on('jwt-error', (requestUrl) => {
                this.$store.dispatch('logout');
                if (!requestUrl.includes('api/check')) {
                    window.store.set('url.intended', this.$route.fullPath);
                    iziToast.info({ message: 'Your session has expired, please sign in again.' });
                    this.$router.push('/signin');
                }
            });
        }
    },
    created () {
        Flash.listener();
        this.fetchAuthUser();
        this.jwtErrorListener();
    }
};
</script>
