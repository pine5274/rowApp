<template>
    <v-app id="inspire">
        <Navbar/>
        <main>
            <v-main>
                <v-container>
                    <RouterView/>
                </v-container>
            </v-main>
        </main>
        <Footer/>
    </v-app>
</template>

<script>
    import Navbar from './components/Navbar.vue'
    import Footer from './components/Footer.vue'
    import { INTERNAL_SERVER_ERROR } from './util'

    export default {
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,
        }),
        components: {
            Navbar,
            Footer,
        },
        computed: {
            errorCode () {
                return this.$store.state.error.code
            }
        },
        watch: {
            errorCode: {
                handler (val) {
                    if (val === INTERNAL_SERVER_ERROR) {
                        this.$router.push('/500')
                    }
                },
                immediate: true
            },
            $route () {
                this.$store.commit('error/setCode', null)
            }
        }
    }
</script>
