<script>
    export default {
        name: "Logout",
        mounted() {
            this.logout()
        },
        methods: {
            logout()
            {
                axios.post('/api/logout').then(response => {
                  window.localStorage.removeItem('access-token')
                  window.localStorage.removeItem('user');
                  location.assign('/login');
                }).catch(error => {
                    console.log('Error occurred');
                });
                
            }
        }
    }
</script>
