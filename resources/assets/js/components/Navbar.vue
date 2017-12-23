<template>
    <nav class="navbar has-shadow">
        <div class="container">

            <div class="navbar-brand">
                <router-link to="/" exact class="navbar-item">{{ $_config.app.name }}</router-link>
                <button class="button navbar-burger" :class="{ 'is-active': isActive }" @click="isActive = !isActive">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div><!-- .navbar-brand -->

            <div class="navbar-menu" :class="{ 'is-active': isActive }">
                <div v-if="$_auth.check" class="navbar-start">
                    <router-link to="/" exact class="navbar-item is-tab">
                        <b-icon icon="home"></b-icon>Timeline
                    </router-link>
                    <router-link to="/friends" class="navbar-item is-tab">
                        <b-icon icon="group"></b-icon>Friends
                    </router-link>
                    <div class="navbar-item">
                        <search-form></search-form>
                    </div>
                </div><!-- .navbar-start -->
                <div class="navbar-end">
                    <div v-if="$_auth.check" class="navbar-item has-dropdown is-hoverable">
                        <router-link :to="profile" class="navbar-link">
                            <figure class="image is-24x24 user-avatar">
                                <img :src="$_auth.user.avatar" :alt="$_auth.user.username">
                            </figure>
                            {{ $_auth.user | fullname }}
                        </router-link>
                        <div class="navbar-dropdown is-right">
                            <a href="#" class="navbar-item">
                                <b-icon icon="edit"></b-icon>Update profile
                            </a>
                            <hr class="navbar-divider">
                            <a class="navbar-item" @click="onClickSignout">
                                <b-icon icon="sign-out"></b-icon>Sign out
                            </a>
                        </div>
                    </div>
                    <router-link v-if="$_auth.guest" to="/signup" class="navbar-item is-tab">
                        <b-icon icon="vcard-o"></b-icon>Sign up
                    </router-link>
                    <router-link v-if="$_auth.guest" to="/signin" class="navbar-item is-tab">
                        <b-icon icon="sign-in"></b-icon>Sign in
                    </router-link>
                </div><!-- .navbar-end -->
            </div><!-- .navbar-menu -->

        </div><!-- .container -->
    </nav>
</template>

<script>
import SearchForm from './SearchForm';
import { fullname } from '@/util/filters';

export default {
    components: { SearchForm },
    filters: { fullname },
    data () {
        return {
            isActive: false
        };
    },
    computed: {
        profile () {
            return `/user/${this.$_auth.user.username}`;
        }
    },
    methods: {
        onClickSignout () {
            this.$http.post('/logout')
                .then((response) => {
                    this.$store.dispatch('logout');
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        }
    },
    watch: {
        '$route' () {
            this.isActive = false;
        }
    }
};
</script>

<style scoped>
.icon, .user-avatar {
    margin-right: 5px;
}
.user-avatar {
    border-radius: 50%;
    overflow: hidden;
}
</style>
