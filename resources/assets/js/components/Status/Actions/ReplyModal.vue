<template>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Reply to {{ status.user.firstname }} {{ status.user.lastname }}</p>
            <button class="delete" @click="$parent.close()"/>
        </header>
        <section class="modal-card-body">

            <status :status="status"/>

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
import Status from '@/components/Status/Status';
import StatusForm from '@/components/Status/StatusForm';

export default {
    components: { Status, StatusForm },
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    methods: {
        onReplyPosted () {
            this.status.replies_count++;
            this.$parent.close();
        }
    },
    watch: {
        '$route' () {
            this.$parent.close();
        }
    }
};
</script>
