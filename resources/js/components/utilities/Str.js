export default {
    methods: {
        slug: function (str) {
            return str.toLowerCase().replace(/ /g, "-");
        }
    }
}