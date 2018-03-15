<template>
    <div class="columns">
        <div class="column is-6">
            <h1 class="title">
                Your friends
                <small class="has-text-grey">{{ friends.length }}</small>
            </h1>

            <spinner v-if="loading"/>
            <template v-else-if="friends.length">
                <user-block v-for="friend in friends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>You have no friends.</p>
        </div>
        <div class="column is-6">
            <h4 class="subtitle">Friend requests</h4>

            <spinner v-if="loading"/>
            <template v-else-if="requests.length">
                <user-block v-for="request in requests" :user="request" :key="request.id"/>
            </template>
            <p v-else>You have no friend requests.</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import Spinner from '@/components/Spinner';

export default {
    metaInfo: { title: 'Friends' },
    components: { UserBlock, Spinner },
    data () {
        return {
            friends: [],
            requests: [],
            loading: true
        };
    },
    created () {
        this.$http.get('/friendships')
            .then(({ data }) => {
                this.loading = false;
                this.friends = data.friends;
                this.requests = data.requests;
            })
            .catch((error) => {
                this.loading = false;
                console.log(error.response);
            });
    }
};
</script>
