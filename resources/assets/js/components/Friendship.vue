<template>
    <div class="content">
        <template v-if="friendship === 'waiting'">
            <p>Waiting for {{ user.firstname }} {{ user.lastname }} to accept your request.</p>
            <button class="button is-light" :class="{ 'is-loading': processing }" @click="onClickCancel">
                <b-icon icon="ban" size="is-small"/>
                <span>Cancel request</span>
            </button>
        </template>

        <template v-else-if="friendship === 'pending'">
            <button class="button is-success" :class="{ 'is-loading': processing }" @click="onClickAccept">
                <b-icon icon="user-plus" size="is-small"/>
                <span>Accept friend request</span>
            </button>
            <button class="button is-light" :class="{ 'is-loading': processing }" @click="onClickDecline">
                <b-icon icon="ban" size="is-small"/>
                <span>Decline</span>
            </button>
        </template>

        <template v-else-if="friendship === 'friends'">
            <p>You and {{ user.firstname }} {{ user.lastname }} are friends.</p>
            <button class="button is-danger" :class="{ 'is-loading': processing }" @click="onClickUnfriend">
                <b-icon icon="user-times" size="is-small"/>
                <span>Unfriend</span>
            </button>
        </template>

        <template v-else-if="friendship === 'not_friends'">
            <button class="button is-primary" :class="{ 'is-loading': processing }" @click="onClickAdd">
                <b-icon icon="user-plus" size="is-small"/>
                <span>Add as friend</span>
            </button>
        </template>
    </div>
</template>

<script>
export default {
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
    data () {
        return { processing: false };
    },
    methods: {
        onClickAdd () {
            this.request('post', '/friendships', { id: this.user.id }, 'waiting');
        },
        onClickAccept () {
            this.request('put', `/friendships/${this.user.id}`, {}, 'friends');
        },
        onClickCancel () {
            this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'cancel' } }, 'not_friends');
        },
        onClickDecline () {
            this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'decline' } }, 'not_friends');
        },
        onClickUnfriend () {
            this.$dialog.confirm({
                message: `Are you sure you want to remove ${this.user.firstname} from your friends?`,
                confirmText: `Unfriend ${this.user.firstname}`,
                type: 'is-danger',
                onConfirm: () => {
                    this.request('delete', `/friendships/${this.user.id}`, { params: { action: 'unfriend' } }, 'not_friends');
                }
            });
        },
        request (requestType, url, data, friendship) {
            this.processing = true;
            this.$http[requestType](url, data)
                .then((response) => {
                    this.processing = false;
                    this.$emit('update:friendship', friendship);
                })
                .catch((error) => {
                    this.processing = false;
                    console.log(error.response);
                });
        }
    }
};
</script>
