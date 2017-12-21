<template>
    <form @submit.prevent="onSubmitSearch">
        <b-field>
            <b-input type="search" placeholder="Find people" v-model="keyword"></b-input>
            <p class="control">
                <button class="button is-primary">
                    <b-icon icon="search"></b-icon>
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
    methods: {
        onSubmitSearch () {
            const keyword = this.keyword.trim();
            if (keyword !== '') {
                this.$router.push({ path: '/search', query: { keyword } });
                this.keyword = '';
            }
        }
    }
};
</script>
