<template>
    <div class="columns">
        <div class="column is-6">
            <h1 class="title">Your friends</h1>

            <template v-if="friends.length">
                <user-block v-for="friend in friends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>You have no friends.</p>
        </div>
        <div class="column is-6">
            <h4 class="subtitle">Friend requests</h4>

            <template v-if="requests.length">
                <user-block v-for="request in requests" :user="request" :key="request.id"/>
            </template>
            <p v-else>You have no friend requests.</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import User from '@/util/User';

export default {
    metaInfo: { title: 'Friends' },
    components: { UserBlock },
    data () {
        return {
            friends: [],
            requests: []
        };
    },
    created () {
        this.$http.get('/friendships')
            .then(({ data }) => {
                this.friends = data.friends.map((user) => new User(user));
                this.requests = data.requests.map((user) => new User(user));
            })
            .catch((error) => console.log(error.response));
    }
};
</script>
