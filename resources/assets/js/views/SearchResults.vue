<template>
    <div>
        <h1 class="title">
            Your search for "{{ keyword }}"
            <small class="has-text-grey">({{ users.length }} results)</small>
        </h1>

        <div class="columns is-multiline">
            <template v-if="users.length">
                <div v-for="user in users" :key="user.id" class="column is-half">
                    <user-block :user="user"/>
                </div>
            </template>
            <div v-else class="column">No results found, sorry.</div>
        </div>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';

export default {
    metaInfo () {
        return { title: `Search '${this.keyword}'` };
    },
    components: { UserBlock },
    data () {
        return {
            users: [],
            keyword: ''
        };
    },
    methods: {
        loadResults () {
            this.keyword = this.$route.query.keyword;
            this.$http.get('/search', { params: { keyword: this.keyword } })
                .then(({ data }) => {
                    this.users = data;
                })
                .catch((error) => console.log(error.response));
        }
    },
    created () {
        this.loadResults();
    },
    watch: {
        '$route.query.keyword' () {
            this.loadResults();
        }
    }
};
</script>
