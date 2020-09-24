<template>
    <v-footer
        color="indigo"
        app
        dark
    >
        <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
        <v-spacer></v-spacer>
        <v-btn text small to="/login">Login / Register</v-btn>
        <v-spacer></v-spacer>
    </v-footer>
</template>
