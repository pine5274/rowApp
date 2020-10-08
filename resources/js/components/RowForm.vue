<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            max-width="600px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-card-text
                    style="height: 800px;"
                >
                </v-card-text>
                <v-card-text style="height: 100px; position: relative">
                    <v-fab-transition>
                        <v-btn
                            color="success"
                            dark
                            absolute
                            top
                            right
                            fab
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </v-fab-transition>
                </v-card-text>
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
