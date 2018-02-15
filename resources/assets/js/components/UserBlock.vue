<template>
    <media-object>
        <router-link slot="image" :to="user.profile()">
            <img :src="user.avatar" :alt="user.username" class="is-rounded">
        </router-link>
        <p slot="content">
            <router-link :to="user.profile()">
                <strong>{{ user.fullname() }}</strong>
            </router-link>
            <small>&#64;{{ user.username }}</small>
            <br>
            {{ user.location }}
        </p>
    </media-object>
</template>

<script>
import MediaObject from './MediaObject';

export default {
    components: { MediaObject },
    props: {
        user: {
            type: Object,
            required: true
        }
    }
};
</script>
