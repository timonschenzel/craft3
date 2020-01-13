<template>
    <div class="w-full">
        <slot></slot>
        <component :is="component"></component>
    </div>
</template>

<script>
import Timeline from './Timeline.vue';
import Communities from './Communities.vue';

export default {

    components: {
        Timeline,
        Communities,
    },

    props: ['component'],

    data()
    {
        return {
            
        }
    },
}
</script>