<template>
    <div class="columns">
        <div class="column is-6">
            <h1>Your friends</h1>

            <template v-if="friends.length">
                <user-block v-for="friend in friends" :user="friend" :key="friend.id"></user-block>
            </template>
            <p v-else>You have no friends.</p>
        </div>
        <div class="column is-6">
            <h4>Friend requests</h4>

            <template v-if="requests.length">
                <user-block v-for="request in requests" :user="request" :key="request.id"></user-block>
            </template>
            <p v-else>You have no friend requests.</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';

export default {
    components: { UserBlock },
    data () {
        return {
            friends: [],
            requests: []
        };
    },
    created () {
        this.$http.get('/friends')
            .then(({ data }) => {
                this.friends = data.friends;
                this.requests = data.requests;
            })
            .catch((error) => console.log(error.response));
    }
};
</script>
