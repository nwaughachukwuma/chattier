<template>
    <article class="media">

        <figure class="media-left">
            <p :class="`image is-${imageSize}x${imageSize}`">
                <slot name="image"/>
            </p>
        </figure>

        <div class="media-content">

            <div class="content">
                <slot name="content"/>
            </div>

            <nav v-if="this.$slots['actions']" class="level is-mobile">
                <div class="level-left">
                    <slot name="actions"/>
                </div>
            </nav>

        </div>

    </article>
</template>

<script>
export default {
    props: {
        imageSize: {
            type: Number,
            default: 48
        }
    }
};
</script>
