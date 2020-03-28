<template>
    <div>
        <div class="faq-wrapper" v-if="listType == 'faq'">
            <div class="faq-item" v-for="(l, index) in list" :key="index">
                <div class="faq-item-title">
                    <span>{{ index+1 }}</span>
                    <h5 class="sub-title">{{ l.question }}</h5>
                </div>
                <div class="faq-content">
                    <p>{{ l.answer }}</p>
                </div>
            </div>
        </div>
        
        <div class="faq-wrapper" v-if="listType == 'benefit'">
            <div class="faq-item" v-for="(l, index) in list" :key="index">
                <div class="faq-item-title">
                    <span>{{ index }}</span>
                    <h5 class="sub-title">Benefit Title</h5>
                </div>
                <div class="faq-content">
                    <p>Description</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['initialList', 'listType'],
        data() {
            return {
                list: []
            }
        },
        created: function () {

        },
        created() {
            this.list = this.initialList;
        },
        mounted() {

            $('.faq-item .faq-item-title').on('click', function (e) {
                var element = $(this).parent('.faq-item');
                if (element.hasClass('open')) {
                    element.removeClass('open');
                    element.find('.faq-item').removeClass('open');
                    element.find('.faq-content').slideUp(700, "swing");
                } else {
                    element.addClass('open');
                    element.children('.faq-content').slideDown(700, "swing");
                    element.siblings('.faq-item').children('.faq-content').slideUp(700, "swing");
                    element.siblings('.faq-item').removeClass('open');
                    element.siblings('.faq-item').find('.faq-item').removeClass('open');
                    element.siblings('.faq-item').find('.faq-content').slideUp(700, "swing");
                }
            });

        }
    }
</script>