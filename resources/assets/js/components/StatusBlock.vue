<template>
    <media-object>
        <router-link slot="image" :to="status.user.profile()">
            <img :src="status.user.avatar" :alt="status.user.username" class="is-rounded">
        </router-link>
        <p slot="content">
            <router-link :to="status.user.profile()" :class="{ 'is-size-5': jumbo }">
                <strong>{{ status.user.fullname() }}</strong>
            </router-link>
            <br v-if="jumbo">
            <small>&#64;{{ status.user.username }}</small>
            <small class="has-text-grey-light">{{ status.created_at | ago }}</small>
            <br>
            <span :class="{ 'is-size-4': jumbo }">{{ status.body }}</span>
        </p>
        <template v-if="actions.length" slot="actions">
            <like v-if="actions.includes('like')" :status="status" @like-toggled="onLikeToggled"/>
            <a v-if="actions.includes('reply')" class="level-item" @click="onClickReply" :disabled="!canReply">
                <b-icon icon="comment-o" size="is-small"/>
                <span>{{ status.reply_count }}</span>
            </a>
            <a v-if="actions.includes('expand')" class="level-item" @click="onClickExpand">
                <b-icon icon="expand" size="is-small"/>
            </a>
            <a v-if="actions.includes('delete') && isMyStatus" class="level-item" @click="onClickDelete">
                <b-icon icon="trash-o" size="is-small"/>
            </a>
        </template>
    </media-object>
</template>

<script>
import MediaObject from './MediaObject';
import Like from './Like';
import { ago } from '@/util/filters';

export default {
    components: { MediaObject, Like },
    filters: { ago },
    props: {
        status: {
            type: Object,
            required: true
        },
        actions: {
            type: Array,
            default: () => []
        },
        jumbo: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        isMyStatus () {
            return this.$_auth.check && this.status.user.id === this.$_auth.id;
        },
        canReply () {
            return (this.isMyStatus || this.status.of_friend) && !this.status.parent_id;
        }
    },
    methods: {
        onLikeToggled () {
            this.status.likes_count += (this.status.liked ? -1 : 1);
            this.status.liked = !this.status.liked;
        },
        onClickReply () {
            this.$modal.open({
                parent: this,
                hasModalCard: true,
                canCancel: ['escape', 'outside'],
                component: require('./ReplyModal'),
                props: { status: this.status }
            });
        },
        onClickExpand () {
            this.$modal.open({
                parent: this,
                hasModalCard: true,
                canCancel: ['escape', 'outside'],
                component: require('./ExpandModal'),
                props: { status: this.status, canReply: this.canReply },
                events: { deleted: (id) => this.$emit('status-deleted', id) }
            });
        },
        onClickDelete () {
            this.$dialog.confirm({
                message: 'Are you sure you want to delete this status?',
                confirmText: 'Delete',
                type: 'is-danger',
                onConfirm: () => {
                    this.$http.delete(`/statuses/${this.status.id}`)
                        .then((response) => this.$emit('status-deleted', this.status.id))
                        .catch((error) => console.log(error.response));
                }
            });
        }
    }
};
</script>
