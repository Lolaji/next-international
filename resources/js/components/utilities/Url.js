export default {
    methods: {
        base_url: function (path="") {
            return window.location.origin+'/'+path;
        }
    }
}