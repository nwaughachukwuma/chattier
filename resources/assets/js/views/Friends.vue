<template>
    <div>
        <b-tabs v-model="tab">
            <b-tab-item :label="`Your friends (${friends.length})`"/>
            <b-tab-item label="Friend requests"/>
        </b-tabs>

        <spinner v-if="loading"/>
        <div v-else-if="users.length" class="columns is-multiline">
            <div v-for="user in users" :key="user.id" class="column is-half">
                <user-block :user="user"/>
            </div>
        </div>
        <p v-else>You have no {{ ['friends', 'friend requests'][tab] }}.</p>
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
            tab: 0,
            friends: [],
            requests: [],
            loading: true
        };
    },
    computed: {
        users () {
            return [this.friends, this.requests][this.tab];
        }
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
