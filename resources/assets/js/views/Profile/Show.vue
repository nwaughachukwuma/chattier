<template>
    <div class="columns">
        <div class="column is-5">
            <user-block :user="user"/>
            <hr>

            <p>Status</p>
            <p>Status</p>
        </div>
        <div class="column is-4 is-offset-3">
            <friendship v-if="showFriendship" :friendship="friendship" :user="user" @friendship-changed="onFriendshipChanged"/>

            <h4>{{ user.firstname }}'s friends</h4>

            <template v-if="friends.length">
                <user-block v-for="friend in friends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>{{ user.firstname }} has no friends.</p>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import Friendship from '@/components/Friendship';

export default {
    metaInfo () {
        return {
            title: `${this.user.firstname} ${this.user.lastname}`
        };
    },
    components: { UserBlock, Friendship },
    data () {
        return {
            user: {},
            friends: [],
            friendship: ''
        };
    },
    computed: {
        showFriendship () {
            return !['unauthenticated', 'same_user'].includes(this.friendship);
        }
    },
    methods: {
        loadProfile () {
            this.$http.get(`/profile/${this.$route.params.username}`)
                .then(({ data }) => {
                    this.user = data.user;
                    this.friends = data.friends;
                    this.friendship = data.friendship;
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.status === 404) {
                        this.$_error(404);
                    }
                });
        },
        onFriendshipChanged (friendship) {
            this.friendship = friendship;

            if (friendship === 'friends') {
                this.friends.push(this.$_auth.user);
            } else if (friendship === 'not_friends') {
                this.friends = this.friends.filter((friend) => friend.id !== this.$_auth.id);
            }
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
