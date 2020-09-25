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
        }
    }
</script>
