<template>
    <div v-if="user" class="columns is-multiline">
        <div class="column is-6-widescreen is-7-desktop is-8-tablet">
            <user-block :user="user" jumbo/>
        </div>

        <div class="column
            is-4-widescreen is-offset-2-widescreen
            is-4-desktop is-offset-1-desktop
            is-4-tablet
        ">
            <friendship v-if="showFriendship" :friendship.sync="friendship" :user="user"/>
        </div>

        <div class="column is-full">
            <hr>
        </div>

        <div class="column is-6-widescreen is-7-desktop is-8-tablet">
            <timeline
                :endpoint="`/profile/${user.id}/statuses`"
                :empty="`${user.firstname} hasn't posted anything yet.`"
                :friendship="friendship"
                :can-post="user.id === $_auth.id"
            />
        </div>

        <div class="column
            is-4-widescreen is-offset-2-widescreen
            is-4-desktop is-offset-1-desktop
            is-4-tablet
            is-hidden-mobile
        ">
            <h4 class="subtitle">
                {{ user.firstname }}'s friends
                <small class="has-text-grey">
                    {{ (friends_total > 6 ? '6 of ' : '') + friends_total }}
                </small>
            </h4>

            <template v-if="friends.length">
                <user-block v-for="friend in displayedFriends" :user="friend" :key="friend.id"/>
            </template>
            <p v-else>{{ user.firstname }} has no friends.</p>
        </div>
    </div>
    <spinner v-else/>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import Friendship from '@/components/Friendship';
import Timeline from '@/components/Status/Timeline';
import Spinner from '@/components/Spinner';
import { removeById } from '@/util/helpers';

export default {
    metaInfo () {
        const user = this.user;
        return { title: (user ? `${user.firstname} ${user.lastname}` : '') };
    },
    components: { UserBlock, Friendship, Timeline, Spinner },
    data () {
        return {
            user: null,
            friends: [],
            friends_total: 0,
            friendship: ''
        };
    },
    computed: {
        showFriendship () {
            return !['unauthenticated', 'same_user'].includes(this.friendship);
        },
        displayedFriends () {
            return this.friends.slice(0, 6);
        }
    },
    methods: {
        loadProfile () {
            this.user = null;
            this.$http.get(`/profile/${this.$route.params.username}`)
                .then(({ data }) => {
                    this.user = data.user;
                    this.friends = data.friends;
                    this.friends_total = data.friends_total;
                    this.friendship = data.friendship;
                })
                .catch((error) => {
                    console.log(error.response);
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
        friendship (current, old) {
            const change = `${old} > ${current}`;
            if (change === 'friends > not_friends') {
                this.friends_total--;
                removeById(this.friends, this.$_auth.id);
            } else if (change === 'pending > friends') {
                this.friends_total++;
                this.friends.unshift(this.$_auth.user);
            }
        },
        '$route.params.username' () {
            this.loadProfile();
        }
    }
};
</script>
