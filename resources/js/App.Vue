<template>
    <v-app id="inspire">
        <Navbar></Navbar>
        <main>
            <v-main>
                <RowForm></RowForm>
                <v-container>
                    <RouterView/>
                </v-container>
            </v-main>
        </main>
        <Footer></Footer>
    </v-app>
</template>

<script>
    import { INTERNAL_SERVER_ERROR } from './util'
    import Navbar from './components/Navbar.vue'
    import Footer from './components/Footer.vue'
    import RowForm from "./components/RowForm";

    export default {
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,
        }),
        components: {
            RowForm,
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
