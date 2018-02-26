<template>
    <a class="navbar-item" @click="nightMode = !nightMode">
        <b-icon icon="moon-o"/>Night mode: {{ nightMode ? 'On' : 'Off' }}
    </a>
</template>

<script>
export default {
    data () {
        return {
            nightMode: false
        };
    },
    created () {
        if (window.store.has('theme.night')) {
            this.nightMode = window.store.get('theme.night');
        }
    },
    beforeDestroy () {
        window.eventBus.$emit('night-mode', false);
    },
    watch: {
        nightMode (current) {
            window.eventBus.$emit('night-mode', current);
        }
    }
};
</script>
