require ('../../../public/assets/admin/plugins/summernote/summernote-bs4');
import '../../../public/assets/admin/plugins/summernote/summernote-bs4';

export default {
    template: '<textarea :name="name"></textarea>',
    props: {
        model: {
            required: true
        },
        name: {
            type: String,
            required: true
        },
        config: {
            type: Object,
            default() {
                return {
                    height: 500,
                }
            }
        }
    },

    mounted() {
        let config = this.config

        let vm = this;

        config.callbacks = {
            onInit: function () {
                $(vm.$el).summernote('code', vm.model);
            },

            onChange: function () {
                vm.$emit('change', $(vm.$el).summernote('code'));
            },

            onBlur: function () {
                vm.$emit('change', $(vm.$el).summernote('code'));
            }
        };

        $(this.$el).summernote(config);
        $('.dropdown-toggle').dropdown();
    }
}