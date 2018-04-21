<template>
    <div>
        <navbar/>
        <section class="section">
            <div class="container">
                <app-view/>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from './Navbar/Navbar';
import Flash from '@/util/Flash';

export default {
    metaInfo: {
        titleTemplate (title) {
            return (title ? `${title} | ` : '') + this.$_config.app.name;
        }
    },
    components: { Navbar },
    methods: {
        jwtErrorListener () {
            window.eventBus.$on('jwt-error', () => {
                this.$store.dispatch('logout');
                window.storage.set('url.intended', this.$route.fullPath);
                Flash.show('Your session has expired, please sign in again.', 'info');
                this.$router.push('/signin');
            });
        }
    },
    created () {
        Flash.listener();
        this.jwtErrorListener();
    }
};
</script>
