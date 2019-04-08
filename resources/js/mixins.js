export default {

    data() {
        return {
            AppName: process.env.MIX_APP_NAME,
        }
    },

    computed: {
        AuthCheck: function () {
            return window.localStorage.getItem('access-token') ? true : false;
        },

        user() {
            return JSON.parse(window.localStorage.getItem('user'));
        },

    },

    mounted() {

    },

    methods: {
        flash(title, type) {
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });

            Toast.fire({
                type: type,
                title: title
            })

        }

    }


};
