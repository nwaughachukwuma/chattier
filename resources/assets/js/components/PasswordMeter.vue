<template>
    <progress
        :class="`progress is-${color}`"
        :value="adjustedScore"
        max="5"
    />
</template>

<script>
import zxcvbn from 'zxcvbn';

export default {
    props: {
        password: {
            type: String,
            required: true
        }
    },
    computed: {
        result () {
            return zxcvbn(this.password);
        },
        adjustedScore () {
            return (this.password ? this.result.score + 1 : 0);
        },
        isWeak () {
            return this.result.score <= 2;
        },
        color () {
            return (this.isWeak ? 'danger' : 'success');
        }
    }
};
</script>

<style scoped>
    .progress {
        height: 0.25rem;
        margin: 0;
    }
    .progress::-webkit-progress-value {
        transition: width 0.5s, background-color 0.5s;
    }
</style>
