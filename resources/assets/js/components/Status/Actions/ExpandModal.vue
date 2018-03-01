<template>
    <div class="modal-card">
        <section class="modal-card-body">

            <template>
                <status
                    :status="status"
                    :actions="['like', 'delete']"
                    jumbo
                    @status-deleted="onStatusDeleted"
                />

                <hr>

                <status-form
                    v-if="canReply"
                    placeholder="Reply to this status"
                    button="Reply"
                    :parent-id="status.id"
                    @reply-posted="onReplyPosted"
                />
                <p v-else class="has-text-centered">
                    You must be friends with {{ status.user.firstname }} to reply to their statuses.
                </p>

                <template v-if="replies.length">
                    <hr>

                    <status
                        v-for="reply in replies"
                        :status="reply"
                        :key="reply.id"
                        :actions="['like', 'delete']"
                        @status-deleted="onReplyDeleted"
                    />
                </template>
            </template>

        </section>
    </div>
</template>

<script>
import Status from '@/components/Status/Status';
import StatusForm from '@/components/Status/StatusForm';

export default {
    components: { Status, StatusForm },
    props: {
        status: {
            type: Object,
            required: true
        },
        canReply: {
            type: Boolean,
            required: true
        }
    },
    data () {
        return {
            replies: []
        };
    },
    methods: {
        fetchReplies () {
            this.$http.get(`/statuses/${this.status.id}/replies`)
                .then(({ data }) => {
                    this.replies = data.reverse();
                })
                .catch((error) => console.log(error.response));
        },
        onStatusDeleted () {
            this.$emit('deleted', this.status.id);
            this.$parent.close();
        },
        onReplyPosted (reply) {
            this.replies.unshift(reply);
        },
        onReplyDeleted (id) {
            this.replies.splice(this.replies.indexOf(
                this.replies.find((reply) => reply.id === id)
            ), 1);
        }
    },
    created () {
        this.fetchReplies();
    },
    watch: {
        replies () {
            this.status.replies_count = this.replies.length;
        }
    }
};
</script>
