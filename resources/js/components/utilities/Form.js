export default {
    data() {
        return {
            input:{}
        }
    },
    methods: {
        resetFormInput: function (input) {
            if (input instanceof Object) {
                Object.entries(input).forEach(([key, value]) => {
                    this.input[key] = '';
                });
            } else {
                console.log('Parameter parsed must be an object in resetForm() Method');
            }
        }
    }
}