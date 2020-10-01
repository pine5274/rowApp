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
    export default {
        methods: {
            async logout () {
                await this.$store.dispatch('auth/logout')

                this.$router.push('/login')
            }
        },
        computed: {
            isLogin () {
                return this.$store.getters['auth/check']
            }
        },
    }
</script>
