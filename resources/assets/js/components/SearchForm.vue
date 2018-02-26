<template>
    <form @submit.prevent="onSubmitSearch">
        <b-field>

            <b-input type="search" placeholder="Find people" v-model="keyword"/>

            <p class="control">
                <button class="button is-primary">
                    <b-icon icon="search"/>
                </button>
            </p>

        </b-field>
    </form>
</template>

<script>
export default {
    data () {
        return {
            keyword: ''
        };
    },
    computed: {
        trimmedKeyword () {
            return this.keyword.trim();
        }
    },
    methods: {
        onSubmitSearch () {
            if (this.trimmedKeyword === '') return;

            this.$router.push({ path: '/search', query: { keyword: this.trimmedKeyword } });
            this.keyword = '';
        }
    }
};
</script>
