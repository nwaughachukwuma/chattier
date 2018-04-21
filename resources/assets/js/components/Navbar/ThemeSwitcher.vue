<template>
    <a class="navbar-item" @click="nightMode = !nightMode">
        <b-icon icon="moon-o"/>Night mode: {{ nightMode ? 'On' : 'Off' }}
    </a>
</template>

<script>
const cssLink = document.head.querySelector('link[title=theme]');

export default {
    data () {
        return { nightMode: false };
    },
    created () {
        if (window.storage.has('theme.night')) {
            this.nightMode = window.storage.get('theme.night');
        }
    },
    watch: {
        nightMode (nightMode) {
            const theme = (nightMode ? 'dark' : 'light');
            cssLink.href = cssLink.href.replace(/theme-*(.*?)*css/g, `theme-${theme}.css`);
            window.storage.set('theme.night', nightMode);
        }
    }
};
</script>
