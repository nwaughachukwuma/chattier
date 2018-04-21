<template>
    <div class="has-text-centered framework-info">
        <h4 class="subtitle">Built with</h4>

        <div v-for="(row, index) in items" :key="index" class="columns is-centered is-vcentered">
            <b-tooltip v-for="{ label, logo, size, site } in row" :key="label" :label="label">
                <a :href="site" target="_blank">
                    <figure :class="`image is-inline-flex ${size}`">
                        <img :src="`/images/${logo}`">
                    </figure>
                </a>
            </b-tooltip>
        </div>

        <p>Made by <strong>Ranie Santos</strong></p>

        <a href="https://github.com/raniesantos"><b-icon icon="github"/></a>
        <a href="https://twitter.com/raniesantos32"><b-icon icon="twitter"/></a>
    </div>
</template>

<script>
export default {
    data () {
        return {
            items: [
                [
                    { label: 'Laravel', logo: 'laravel.png', size: 'is-96x96', site: 'https://laravel.com/' },
                    { label: 'Vue.js', logo: 'vue.png', size: 'is-96x96', site: 'https://vuejs.org/' }
                ],
                [
                    { label: 'Bulmaswatch', logo: 'bulmaswatch.png', size: 'is-48x48', site: 'https://jenil.github.io/bulmaswatch/' },
                    { label: 'Bulma', logo: 'bulma.png', size: 'is-96x96', site: 'https://bulma.io/' },
                    { label: 'Buefy', logo: 'buefy.png', size: 'is-48x48', site: 'https://buefy.github.io/' }
                ]
            ]
        };
    }
};
</script>
