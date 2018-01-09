<template>
    <div>
        <template v-if="friendship === 'waiting'">
            <p>Waiting for {{ user | fullname }} to accept your request.</p>
            <button class="button is-primary" @click="onClickCancel">
                Cancel request
            </button>
        </template>

        <template v-else-if="friendship === 'pending'">
            <button class="button is-success" @click="onClickAccept">
                Accept friend request
            </button>
            <button class="button is-danger" @click="onClickDecline">
                Decline
            </button>
        </template>

        <template v-else-if="friendship === 'friends'">
            <p>You and {{ user | fullname }} are friends.</p>
            <button class="button is-danger" @click="onClickUnfriend">
                Unfriend
            </button>
        </template>

        <button v-else-if="friendship === 'not friends'" class="button is-primary" @click="onClickAdd">
            Add as friend
        </button>

        <hr>
    </div>
</template>

<script>
import { fullname } from '@/util/filters';

export default {
    filters: { fullname },
    props: {
        friendship: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },
    methods: {
        onClickAdd () {
            this.request('post', '/friendships', { id: this.user.id }, 'waiting');
        },
        onClickAccept () {
            this.request('put', `/friendships/${this.user.id}`, {}, 'friends');
        },
        onClickCancel () {
            this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'cancel' } }, 'not friends');
        },
        onClickDecline () {
            this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'decline' } }, 'not friends');
        },
        onClickUnfriend () {
            this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'unfriend' } }, 'not friends');
        },
        request (requestType, url, data, friendship) {
            this.$http[requestType](url, data)
                .then((response) => this.$emit('friendship-changed', friendship))
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
