<template>
    <media-object>
        <router-link slot="image" :to="status.user.profile()">
            <img :src="status.user.avatar" :alt="status.user.username" class="is-rounded">
        </router-link>
        <p slot="content">
            <router-link :to="status.user.profile()">
                <strong>{{ status.user.fullname() }}</strong>
            </router-link>
            <small>&#64;{{ status.user.username }}</small>
            <small>{{ status.created_at | ago }}</small>
            <br>
            {{ status.body }}
        </p>
        <template v-if="actions.length" slot="actions">
            <a v-if="actions.includes('like')" class="level-item" :disabled="!canLike">
                <b-icon icon="thumbs-o-up" size="is-small"/>
                <span>99</span>
            </a>
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
import { ago } from '@/util/filters';

export default {
    components: { MediaObject },
    filters: { ago },
    props: {
        status: {
            type: Object,
            required: true
        },
        actions: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        isMyStatus () {
            return this.$_auth.check && this.status.user.id === this.$_auth.id;
        },
        canLike () {
            return this.$_auth.check && this.status.of_friend;
        },
        canReply () {
            return (this.isMyStatus || this.status.of_friend) && !this.status.parent_id;
        }
    },
    methods: {
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

<style scoped>
    .level-item[disabled] {
        pointer-events: none;
        opacity: 0.4;
    }
    .level-item .icon:not(:last-child) {
        margin-right: 0.25rem;
    }
</style>
