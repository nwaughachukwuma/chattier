<template>
    <div v-infinite-scroll="fetchStatuses" infinite-scroll-disabled="disabled">

        <template v-if="$_auth.check && canPost">
            <status-form
                :placeholder="`What's up ${$_auth.user.firstname}?`"
                button="Post status"
                @status-posted="onStatusPosted"
            />

            <hr>
        </template>

        <template v-if="statuses.length">
            <status
                v-for="status in statuses"
                :status="status"
                :key="status.id"
                :actions="['like', 'reply', 'expand', 'delete']"
                @status-deleted="onStatusDeleted"
            />
        </template>
        <p v-else>{{ empty }}</p>

        <div class="has-text-centered" :class="{ 'is-invisible': !loading }">
            <b-icon icon="spinner" custom-class="fa-pulse" size="is-medium"/>
        </div>

    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll';
import Status from './Status';
import StatusForm from './StatusForm';

export default {
    components: { Status, StatusForm },
    directives: { infiniteScroll },
    props: {
        endpoint: {
            type: String,
            required: true
        },
        empty: {
            type: String,
            default: 'No statuses yet.'
        },
        canPost: {
            type: Boolean,
            default: false
        },
        friendship: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            statuses: [],
            cursor: null,
            loading: false,
            last: false
        };
    },
    computed: {
        disabled () {
            return this.loading || this.last;
        }
    },
    methods: {
        fetchStatuses () {
            this.loading = true;
            this.$http.get(this.endpoint, {
                params: { cursor: this.cursor }
            })
                .then(({ data }) => {
                    this.loading = false;

                    this.statuses = this.statuses.concat(data.records);
                    this.cursor = (data.has_next ? data.next_cursor.id : null);
                    this.last = !data.has_next;
                })
                .catch((error) => {
                    setTimeout(() => (this.loading = false), 1000);
                    console.log(error.response);
                });
        },
        onStatusPosted (status) {
            this.statuses.unshift(status);
        },
        onStatusDeleted (id) {
            this.statuses.splice(this.statuses.indexOf(
                this.statuses.find((status) => status.id === id)
            ), 1);
        }
    },
    watch: {
        friendship (current, old) {
            const change = `${old} > ${current}`;
            if (['friends > not_friends', 'pending > friends'].includes(change)) {
                this.statuses.forEach((status) => {
                    status.of_friend = (this.friendship === 'friends');
                });
            }
        }
    }
};
</script>
