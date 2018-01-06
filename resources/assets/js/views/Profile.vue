<template>
    <div class="columns">
        <div class="column is-5">
            <user-block :user="user"/>
            <hr>

            <p>Status</p>
            <p>Status</p>
        </div>
        <div class="column is-4 is-offset-3">
            <h4>{{ user.firstname }}'s friends</h4>

            <template v-if="user.friends.length">
                <user-block v-for="friend in user.friends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>{{ user.firstname }} has no friends.</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';

export default {
    components: { UserBlock },
    data () {
        return {
            user: {
                friends: []
            }
        };
    },
    methods: {
        loadProfile () {
            this.$http.get(`/profile/${this.$route.params.username}`)
                .then(({ data }) => {
                    this.user = data.user;
                    console.log(data);
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
