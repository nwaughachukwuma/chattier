<template>
    <div>
        <template v-if="friendship === 'waiting'">
            <p>Waiting for {{ user | fullname }} to accept your request.</p>

            <button class="button is-primary">
                Cancel request
            </button>
        </template>

        <template v-else-if="friendship === 'pending'">
            <button class="button is-success">
                Accept friend request
            </button>
            <button class="button is-danger">
                Decline
            </button>
        </template>

        <template v-else-if="friendship === 'friends'">
            <p>You and {{ user | fullname }} are friends.</p>

            <button class="button is-danger">
                Unfriend
            </button>
        </template>

        <button v-else-if="friendship === 'not friends'" class="button is-primary">
            Add as friend
        </button>

        <hr>
    </div>
</template>

<script>
import { fullname } from '@/util/filters';

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
    filters: { fullname }
};
</script>
