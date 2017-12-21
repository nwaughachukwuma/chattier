<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-48x48">
                <router-link :to="profile">
                    <img :src="user.avatar" :alt="user.username">
                </router-link>
            </p>
        </figure><!-- .media-left -->
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>
                        <router-link :to="profile">
                            {{ user | fullname }}
                        </router-link>
                    </strong>
                    <small>&#64;{{ user.username }}</small>
                    <br>
                    {{ user.location }}
                </p>
            </div>
        </div><!-- .media-content -->
    </article>
</template>

<script>
import { fullname } from '@/util/filters';

export default {
    props: ['user'],
    filters: { fullname },
    computed: {
        profile () {
            return '/user/' + this.user.username;
        }
    }
};
</script>
