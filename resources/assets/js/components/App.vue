<template>
    <div>
        <navbar/>
        <section v-if="ready" class="section">
            <div class="container content">
                <app-view/>
            </div>
        </section>
        <b-loading :active="!ready"/>
    </div>
</template>

<script>
import Navbar from './Navbar';
import Flash from '@/util/Flash';

export default {
    metaInfo: {
        titleTemplate (title) {
            return (title ? `${title} | ` : '') + this.$_config.app.name;
        }
    },
    components: { Navbar },
    data () {
        return {
            loaded: {
                auth: true
            }
        };
    },
    computed: {
        ready () {
            return Object.values(this.loaded).every((bool) => bool);
        }
    },
    methods: {
        fetchAuthUser () {
            if (window.store.has('auth.token')) {
                this.loaded.auth = false;
                this.$http.get('/user')
                    .then((response) => {
                        this.$store.commit('setUser', response.data);
                        this.loaded.auth = true;
                    })
                    .catch((error) => {
                        console.log(error.response);
                        this.loaded.auth = true;
                    });
            }
        },
        jwtErrorListener () {
            window.eventBus.$on('jwt-error', (requestUrl) => {
                this.$store.dispatch('logout');
                if (!requestUrl.includes('api/check')) {
                    window.store.set('url.intended', this.$route.fullPath);
                    Flash.show('Your session has expired, please sign in again.', 'info');
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
