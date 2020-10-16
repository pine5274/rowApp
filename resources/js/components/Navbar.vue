<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <v-list dense>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-action>
                        <v-icon>mdi-email</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Contact</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            color="indigo"
            dense
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <span class="hidden-sm-and-down">Application</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <span v-if="isLogin">{{ username }}</span>
            <router-link v-else to="/login">
                <v-btn text to="/login">Login / Register</v-btn>
            </router-link>
        </v-app-bar>
    </div>
</template>
<script>
    export default {
        data: () => ({
            drawer: null,
        }),
        computed: {
            isLogin () {
                return this.$store.getters['auth/check']
            },
            username () {
                return this.$store.getters['auth/username']
            }
        }
    }
</script>
<style scoped>
    a {
        text-decoration: none;
    }
</style>
