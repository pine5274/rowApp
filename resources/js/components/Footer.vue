<template>
    <v-footer
        color="indigo"
        app
        dark
    >
        <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
        <v-spacer></v-spacer>
        <v-btn v-if="isLogin" text small @click="logout">Logout</v-btn>
        <v-btn v-else text small to="/login">Login / Register</v-btn>
        <v-spacer></v-spacer>
    </v-footer>
</template>

<script>
    import { mapState, mapGetters } from 'vuex'

    export default {
        computed: {
            ...mapState({
                apiStatus: state => state.auth.apiStatus
            }),
            ...mapGetters({
                isLogin: 'auth/check'
            })
        },
        methods: {
            async logout () {
                await this.$store.dispatch('auth/logout')

                if (this.apiStatus) {
                    this.$router.push('/login')
                }
            }
        }
    }
</script>
