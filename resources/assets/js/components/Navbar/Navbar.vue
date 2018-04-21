<template>
    <nav class="navbar has-shadow">
        <div class="container">
            <div class="navbar-brand">
                <router-link to="/" exact active-class class="navbar-item">
                    <strong>{{ $_config.app.name }}</strong>
                </router-link>
                <div class="navbar-burger" :class="{ 'is-active': isActive }" @click="isActive = !isActive">
                    <span/><span/><span/>
                </div>
            </div><!-- .navbar-brand -->

            <div class="navbar-menu" :class="{ 'is-active': isActive }">

                <div v-if="$_auth.check" class="navbar-start">
                    <router-link to="/" exact class="navbar-item">
                        <b-icon icon="home"/>Timeline
                    </router-link>
                    <router-link to="/friends" class="navbar-item">
                        <b-icon icon="group"/>Friends
                    </router-link>
                    <div class="navbar-item">
                        <search-form/>
                    </div>
                </div><!-- .navbar-start -->

                <div class="navbar-end">

                    <router-link v-if="$_auth.check" :to="profile($_auth.user)" class="navbar-item">
                        <figure class="image is-24x24 user-avatar is-inline-block">
                            <img :src="$_auth.user.avatar" :alt="$_auth.user.username" class="is-rounded">
                        </figure>
                        {{ $_auth.user.firstname }} {{ $_auth.user.lastname }}
                    </router-link>

                    <template v-if="$_auth.guest">
                        <router-link to="/signup" class="navbar-item">
                            <b-icon icon="vcard-o"/>Sign up
                        </router-link>
                        <router-link to="/signin" class="navbar-item">
                            <b-icon icon="sign-in"/>Sign in
                        </router-link>
                    </template>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link"/>
                        <div class="navbar-dropdown is-right">
                            <template v-if="$_auth.check">
                                <router-link to="/profile/edit" class="navbar-item">
                                    <b-icon icon="edit"/>Update profile
                                </router-link>
                                <router-link to="/password/change" class="navbar-item">
                                    <b-icon icon="lock"/>Change password
                                </router-link>
                            </template>

                            <theme-switcher/>

                            <template v-if="$_auth.check">
                                <hr class="navbar-divider">
                                <a class="navbar-item" @click="onClickSignout">
                                    <b-icon icon="sign-out"/>Sign out
                                </a>
                            </template>
                        </div><!-- .navbar-dropdown -->
                    </div><!-- .navbar-item.has-dropdown -->

                </div><!-- .navbar-end -->

            </div><!-- .navbar-menu -->
        </div><!-- .container -->
    </nav>
</template>

<script>
import SearchForm from './SearchForm';
import ThemeSwitcher from './ThemeSwitcher';
import { profile } from '@/util/mixins';

export default {
    components: { SearchForm, ThemeSwitcher },
    mixins: [profile],
    data () {
        return { isActive: false };
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
