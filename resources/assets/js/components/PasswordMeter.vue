<template>
    <div>
        <progress
            :class="`progress is-${color}`"
            :value="adjustedScore"
            max="5"
        />
        <p class="help is-danger">{{ warning }}</p>
    </div>
</template>

<script>
export default {
    props: {
        password: {
            type: String,
            required: true
        }
    },
    data () {
        return {
            adjustedScore: 0,
            warning: '',
            color: ''
        };
    },
    created () {
        import('zxcvbn');
    },
    watch: {
        password (password) {
            import('zxcvbn').then((zxcvbn) => {
                const result = zxcvbn(password);

                this.adjustedScore = (password ? result.score + 1 : 0);
                this.warning = result.feedback.warning;
                this.color = (result.score <= 2 ? 'danger' : 'success');
            });
        },
        warning (warning) {
            if (warning !== '' && !warning.endsWith('.')) {
                this.warning = `${warning}.`;
            }
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
