<template>
    <article class="media">

        <figure class="media-left">
            <p class="image is-48x48">
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
