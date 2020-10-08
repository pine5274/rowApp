<template>
    <v-card>
        <v-card-actions>
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
                @submit.prevent="submit"
            >
                <v-text-field
                    v-model="rowForm.boatName"
                    :rules="boatNameRules"
                    label="boatName"
                    required
                ></v-text-field>

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
                <v-btn
                    color="success"
                    class="mr-4"
                    @click="addRow"
                >
                    Submit
                </v-btn>
            </v-form>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        props: {
            source: String,
        },
        data: () => ({
            valid: true,
            rowForm: {
                boatName: '',
                date: new Date().toISOString().substr(0, 10),
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
            }
        }
    }
</script>
