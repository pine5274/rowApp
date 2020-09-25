<template>
    <v-card
        max-width="600"
    >
        <v-tabs v-model="tab">
            <v-tab>Login</v-tab>
            <v-tab>Regster</v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item>
                <v-card flat>
                    <v-card-actions>
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <v-text-field
                                v-model="loginForm.email"
                                :rules="emailRules"
                                label="E-mail"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="loginForm.password"
                                :rules="passwordRules"
                                label="Password"
                                required
                            ></v-text-field>

                            <v-btn
                                :disabled="valid"
                                color="success"
                                class="mr-4"
                                @click="login"
                            >
                                Submit
                            </v-btn>
                        </v-form>
                    </v-card-actions>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-actions>
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                        >
                            <v-text-field
                                v-model="registerForm.name"
                                :counter="10"
                                :rules="nameRules"
                                label="Name"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="registerForm.email"
                                :rules="emailRules"
                                label="E-mail"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="registerForm.password"
                                :rules="passwordRules"
                                label="password"
                                required
                            ></v-text-field>

                            <v-text-field
                                v-model="registerForm.password_confirmation"
                                :rules="passwordRules"
                                label="password_confirmation"
                                required
                            ></v-text-field>

                            <v-btn
                                color="success"
                                class="mr-4"
                                @click="register"
                            >
                                Submit
                            </v-btn>
                        </v-form>
                    </v-card-actions>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script>
    export default {
        data () {
            return {
                valid: true,
                loginForm: {
                    email: '',
                    password: ''
                },
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                nameRules: [
                    v => !!v || 'Name is required',
                    v => (v && v.length <= 10) || 'Name must be less than 10 characters',
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length <= 16) || 'Password must be less than 16 characters',
                ],
                tab: null,
            }
        },
        methods: {
            login () {
                console.log(this.loginForm)
            },
            register () {
                console.log(this.registerForm)
            },
            // validate () {
            //     this.$refs.form.validate()
            // },
            // reset () {
            //     this.$refs.form.reset()
            // },
            // resetValidation () {
            //     this.$refs.form.resetValidation()
            // },
        },
    }
</script>
