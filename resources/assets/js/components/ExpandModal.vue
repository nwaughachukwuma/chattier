<template>
    <div class="modal-card">
        <section class="modal-card-body">

            <template>
                <status-block
                    :status="status"
                    :actions="['like', 'delete']"
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

                    <status-block
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
import StatusBlock from './StatusBlock';
import StatusForm from './StatusForm';
import User from '@/util/User';

export default {
    components: { StatusBlock, StatusForm },
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
        morphStatusUser (status) {
            status.user = new User(status.user);
            return status;
        },
        fetchReplies () {
            this.$http.get(`/statuses/${this.status.id}/replies`)
                .then(({ data }) => {
                    this.replies = data.reverse().map(this.morphStatusUser);
                })
                .catch((error) => console.log(error.response));
        },
        onStatusDeleted () {
            this.$emit('deleted', this.status.id);
            this.$parent.close();
        },
        onReplyPosted (reply) {
            this.replies.unshift(this.morphStatusUser(reply));
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
            this.status.reply_count = this.replies.length;
        }
    }
};
</script>
