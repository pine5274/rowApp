<template>
    <v-card
        max-width="600"
    >
        <v-tabs v-model="tab">
            <v-tab>Login</v-tab>
            <v-tab>Register</v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item>
                <v-card flat>
                    <v-card-actions>
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                            @submit.prevent="login"
                        >
                            <v-alert
                                text
                                type="error"
                                v-if="loginErrors">
                                    <ul v-if="loginErrors.email">
                                        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                                    </ul>
                                    <ul v-if="loginErrors.password">
                                        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                                    </ul>
                            </v-alert>
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
                            @submit.prevent="register"
                        >
                            <v-alert
                                text
                                type="error"
                                v-if="registerErrors">
                                <ul v-if="registerErrors.name">
                                    <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                                </ul>
                                <ul v-if="registerErrors.email">
                                    <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                                </ul>
                                <ul v-if="registerErrors.password">
                                    <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                                </ul>
                            </v-alert>
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
            async register () {
                // authストアのresigterアクションを呼び出す
                await this.$store.dispatch('auth/register', this.registerForm)

                if (this.apiStatus) {
                    // トップページに移動する
                    this.$router.push('/')
                }
            },
            async login () {
                // authストアのloginアクションを呼び出す
                await this.$store.dispatch('auth/login', this.loginForm)

                if (this.apiStatus) {
                    // トップページに移動する
                    this.$router.push('/')
                }
            },
            clearError () {
                this.$store.commit('auth/setLoginErrorMessages', null)
                this.$store.commit('auth/setRegisterErrorMessages', null)
            }
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
        created () {
            this.clearError()
        },
        computed: {
            apiStatus () {
                return this.$store.state.auth.apiStatus
            },
            loginErrors () {
                return this.$store.state.auth.loginErrorMessages
            },
            registerErrors () {
                return this.$store.state.auth.registerErrorMessages
            }
        },
    }
</script>
