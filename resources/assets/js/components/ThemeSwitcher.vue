<template>
    <a class="navbar-item" @click="nightMode = !nightMode">
        <b-icon icon="moon-o"/>Night mode: {{ nightMode ? 'On' : 'Off' }}
    </a>
</template>

<script>
const cssLink = document.head.querySelector('link[title=theme]');

export default {
    data () {
        return {
            nightMode: false
        };
    },
    methods: {
        setTheme (nightMode) {
            const theme = (nightMode ? 'dark' : 'light');
            cssLink.href = cssLink.href.replace(/theme-*(.*?)*css/g, `theme-${theme}.css`);
            window.store.set('theme.night', nightMode);
        }
    },
    created () {
        if (window.store.has('theme.night')) {
            this.nightMode = window.store.get('theme.night');
        }
    },
    beforeDestroy () {
        this.setTheme(false);
    },
    watch: {
        nightMode (current) {
            this.setTheme(current);
        }
    }
};
</script>
