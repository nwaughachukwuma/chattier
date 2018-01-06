<template>
    <div class="columns">
        <div class="column is-5">
            <user-block :user="user"/>
            <hr>

            <p>Status</p>
            <p>Status</p>
        </div>
        <div class="column is-4 is-offset-3">
            <friendship v-if="showFriendship" :friendship="friendship" :user="user"/>

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
import Friendship from '@/components/Friendship';

export default {
    components: { UserBlock, Friendship },
    data () {
        return {
            user: {
                friends: []
            },
            friendship: ''
        };
    },
    computed: {
        showFriendship () {
            return !['unauthenticated', 'same user'].includes(this.friendship);
        }
    },
    methods: {
        loadProfile () {
            this.$http.get(`/profile/${this.$route.params.username}`)
                .then(({ data }) => {
                    this.user = data.user;
                    this.friendship = data.friendship;
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
