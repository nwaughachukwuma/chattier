<template>
    <a :class="classes" @click="onClickLike" :disabled="!canLike">
        <b-icon :icon="icon" size="is-small"/>
        <span>{{ status.likes_count }}</span>
    </a>
</template>

<script>
export default {
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    computed: {
        classes () {
            return [
                'level-item',
                (this.status.liked ? 'has-text-success' : '')
            ];
        },
        icon () {
            return (this.status.liked ? 'thumbs-up' : 'thumbs-o-up');
        },
        canLike () {
            return this.$_auth.check && this.status.of_friend;
        }
    },
    methods: {
        onClickLike () {
            const requestType = (this.status.liked ? 'delete' : 'post');

            this.$http[requestType](`/statuses/${this.status.id}/likes`);
            this.$emit('like-toggled');
        }
    }
};
</script>
