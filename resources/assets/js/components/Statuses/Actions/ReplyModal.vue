<template>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Reply to {{ status.user.fullname() }}</p>
            <button class="delete" @click="$parent.close()"/>
        </header>
        <section class="modal-card-body">

            <status-block :status="status"/>

            <hr>

            <status-form
                placeholder="Reply to this status"
                button="Reply"
                :parent-id="status.id"
                @reply-posted="onReplyPosted"
            />

        </section>
    </div>
</template>

<script>
import StatusBlock from '@/components/Statuses/StatusBlock';
import StatusForm from '@/components/Statuses/StatusForm';

export default {
    components: { StatusBlock, StatusForm },
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    methods: {
        onReplyPosted () {
            this.status.reply_count++;
            this.$parent.close();
        }
    }
};
</script>
