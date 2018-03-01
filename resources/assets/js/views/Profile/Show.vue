<template>
    <div v-if="user" class="columns">
        <div class="column is-6-widescreen">

            <user-block :user="user"/>

            <hr>

            <timeline
                :endpoint="`/profile/${user.id}/statuses`"
                :empty="`${user.firstname} hasn't posted anything yet.`"
                :friendship="friendship"
                :can-post="user.id === $_auth.id"
            />

        </div>

        <div class="column is-4-widescreen is-offset-2-widescreen">

            <friendship v-if="showFriendship" :friendship="friendship" :user="user" @friendship-changed="onFriendshipChanged"/>

            <h4 class="subtitle">{{ user.firstname }}'s friends</h4>

            <template v-if="friends.length">
                <user-block v-for="friend in friends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>{{ user.firstname }} has no friends.</p>

        </div>
    </div>
    <div v-else class="has-text-centered">
        <b-icon icon="spinner" custom-class="fa-pulse" size="is-medium"/>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import Friendship from '@/components/Friendship';
import Timeline from '@/components/Status/Timeline';

export default {
    metaInfo () {
        const user = this.user;
        return { title: (user ? `${user.firstname} ${user.lastname}` : '') };
    },
    components: { UserBlock, Friendship, Timeline },
    data () {
        return {
            user: null,
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
            this.user = null;
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
                this.friends.splice(this.friends.indexOf(
                    this.friends.find((friend) => friend.id === this.$_auth.id)
                ), 1);
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
