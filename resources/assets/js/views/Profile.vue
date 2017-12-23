<template>
    <div class="columns">
        <div class="column is-5">
            <user-block :user="user"></user-block>
            <hr>

            <p>Status</p>
            <p>Status</p>
        </div>
        <div class="column is-4 is-offset-3">
            <h4>{{ user.firstname }}'s friends</h4>

            <p>Friend</p>
            <p>Friend</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';

export default {
    components: { UserBlock },
    data () {
        return {
            user: {}
        };
    },
    methods: {
        loadProfile () {
            this.$http.get(`/profile/${this.$route.params.username}`)
                .then((response) => {
                    this.user = response.data.user;
                })
                .catch((error) => {
                    if (error.response.status === 404) {
                        this.$_error(404);
                    }
                });
        }
    },
    created () {
        this.loadProfile();
    },
    watch: {
        '$route.params.username' () {
            this.loadProfile();
        }
    }
};
</script>
