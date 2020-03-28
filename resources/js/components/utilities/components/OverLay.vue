<template>
    <div>
        <div class="overlay d-flex justify-content-center align-items-center" :class="{'invisible': show_overlay}">
            <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
    </div>
</template>

<script>
import func from '../../../../../vue-temp/vue-editor-bridge';
    export default {
        props: ['show'],
        data() {
            return {
                // determine if the overlay should be shown or hide.
                show_overlay: false
            };
        },
        mounted() {
            this.$nextTick(function () {
                this.show_overlay = this.show;
            });
        }
    }
</script>