<template>
    <div>
        <h1 class="title">Your search for "{{ keyword }}"</h1>
        <h4 class="subtitle has-text-grey">{{ users.length }} results</h4>

        <spinner v-if="loading"/>
        <div v-else-if="users.length" class="columns is-multiline">
            <div v-for="user in users" :key="user.id" class="column is-half">
                <user-block :user="user"/>
            </div>
        </div>
        <p v-else>No results found, sorry.</p>
    </div>
</template>

<script>
import UserBlock from '@/components/UserBlock';
import Spinner from '@/components/Spinner';

export default {
    metaInfo () {
        return { title: `Search '${this.keyword}'` };
    },
    components: { UserBlock, Spinner },
    data () {
        return {
            users: [],
            keyword: '',
            loading: true
        };
    },
    methods: {
        loadResults () {
            this.loading = true;
            this.users = [];
            this.keyword = this.$route.query.keyword;
            this.$http.get('/search', { params: { keyword: this.keyword } })
                .then(({ data }) => {
                    this.loading = false;
                    this.users = data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error.response);
                });
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
