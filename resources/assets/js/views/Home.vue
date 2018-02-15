<template>
    <div class="columns">
        <div class="column is-6-widescreen">
            <timeline
                v-if="$_auth.check"
                endpoint="/statuses"
                empty="There's nothing in your timeline yet."
                can-post
            />
            <template v-else>
                <h1 class="title">Welcome to {{ $_config.app.name }}</h1>
                <p>The actual best social network ever.</p>
            </template>
        </div>
    </div>
</template>

<script>
import Timeline from '@/components/Timeline';

export default {
    metaInfo () {
        return { title: (this.$_auth.check ? 'Timeline' : '') };
    },
    components: { Timeline }
};
</script>
