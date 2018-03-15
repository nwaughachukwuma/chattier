<template>
    <media-object :image-size="(jumbo ? 64 : 48)">
        <router-link slot="image" :to="profile(user)">
            <img :src="user.avatar" :alt="user.username" class="is-rounded">
        </router-link>
        <p slot="content">
            <router-link :to="profile(user)" :class="{ 'is-size-5': jumbo }">
                <strong>{{ user.firstname }} {{ user.lastname }}</strong>
            </router-link>
            <small>&#64;{{ user.username }}</small>
            <br>
            {{ user.location }}
        </p>
    </media-object>
</template>

<script>
import MediaObject from './MediaObject';
import { profile } from '@/util/mixins';

export default {
    components: { MediaObject },
    mixins: [profile],
    props: {
        user: {
            type: Object,
            required: true
        },
        jumbo: {
            type: Boolean,
            default: false
        }
    }
};
</script>
