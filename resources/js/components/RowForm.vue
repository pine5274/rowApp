<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            max-width="600px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    Open Dialog
                </v-btn>
            </template>
            <v-card>
                <v-form
                    ref="form"
                    v-model="valid"
                    lazy-validation
                    @submit.prevent="submit"
                >
                    <v-card-title class="headline">
                        出艇表
                    </v-card-title>
                    <v-card-text>
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="rowForm.date"
                                    label="Picker without buttons"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="rowForm.date"
                                @input="menu = false"
                            ></v-date-picker>
                        </v-menu>
                        <v-text-field
                            v-model="rowForm.boatName"
                            :rules="boatNameRules"
                            label="boatName"
                            required
                        ></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="grey darken-1"
                            text
                            @click="dialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue"
                            text
                            @click="addRow"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>


            <!--            <v-card>-->
<!--                <v-card-title>-->
<!--                    <span class="headline">User Profile</span>-->
<!--                </v-card-title>-->
<!--                <v-card-text>-->
<!--                    <v-container>-->
<!--                        <v-row>-->
<!--                            <v-col-->
<!--                                cols="12"-->
<!--                                sm="6"-->
<!--                                md="4"-->
<!--                            >-->
<!--                                <v-text-field-->
<!--                                    label="Legal first name*"-->
<!--                                    required-->
<!--                                ></v-text-field>-->
<!--                            </v-col>-->
<!--                            <v-col-->
<!--                                cols="12"-->
<!--                                sm="6"-->
<!--                                md="4"-->
<!--                            >-->
<!--                                <v-text-field-->
<!--                                    label="Legal middle name"-->
<!--                                    hint="example of helper text only on focus"-->
<!--                                ></v-text-field>-->
<!--                            </v-col>-->
<!--                            <v-col-->
<!--                                cols="12"-->
<!--                                sm="6"-->
<!--                                md="4"-->
<!--                            >-->
<!--                                <v-text-field-->
<!--                                    label="Legal last name*"-->
<!--                                    hint="example of persistent helper text"-->
<!--                                    persistent-hint-->
<!--                                    required-->
<!--                                ></v-text-field>-->
<!--                            </v-col>-->
<!--                            <v-col cols="12">-->
<!--                                <v-text-field-->
<!--                                    label="Email*"-->
<!--                                    required-->
<!--                                ></v-text-field>-->
<!--                            </v-col>-->
<!--                            <v-col cols="12">-->
<!--                                <v-text-field-->
<!--                                    label="Password*"-->
<!--                                    type="password"-->
<!--                                    required-->
<!--                                ></v-text-field>-->
<!--                            </v-col>-->
<!--                            <v-col-->
<!--                                cols="12"-->
<!--                                sm="6"-->
<!--                            >-->
<!--                                <v-select-->
<!--                                    :items="['0-17', '18-29', '30-54', '54+']"-->
<!--                                    label="Age*"-->
<!--                                    required-->
<!--                                ></v-select>-->
<!--                            </v-col>-->
<!--                            <v-col-->
<!--                                cols="12"-->
<!--                                sm="6"-->
<!--                            >-->
<!--                                <v-autocomplete-->
<!--                                    :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"-->
<!--                                    label="Interests"-->
<!--                                    multiple-->
<!--                                ></v-autocomplete>-->
<!--                            </v-col>-->
<!--                        </v-row>-->
<!--                    </v-container>-->
<!--                    <small>*indicates required field</small>-->
<!--                </v-card-text>-->
<!--                <v-card-actions>-->
<!--                    <v-spacer></v-spacer>-->
<!--                    <v-btn-->
<!--                        color="blue darken-1"-->
<!--                        text-->
<!--                        @click="dialog = false"-->
<!--                    >-->
<!--                        Close-->
<!--                    </v-btn>-->
<!--                    <v-btn-->
<!--                        color="blue darken-1"-->
<!--                        text-->
<!--                        @click="dialog = false"-->
<!--                    >-->
<!--                        Save-->
<!--                    </v-btn>-->
<!--                </v-card-actions>-->
<!--            </v-card>-->
        </v-dialog>
    </v-row>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            valid: true,
            rowForm: {
                date: new Date().toISOString().substr(0, 10),
                boatName: '',
            },
            boatNameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            ],
            date: new Date().toISOString().substr(0, 10),
            menu: false,
        }),
        methods: {
            login () {
                console.log(this.rowForm)
            },
            async addRow () {
                const response = await axios.post('/api/rows', {
                    boat_name: this.rowForm.boatName,
                    date_time: this.rowForm.date,
                })
                this.dialog = false
            }
        }
    }
</script>
