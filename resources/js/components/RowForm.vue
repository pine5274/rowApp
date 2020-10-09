<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            max-width="640px"
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
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    class="py-1"
                                >
                                    <v-menu
                                        v-model="menuDate"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="rowForm.date"
                                                label="日付"
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
                                </v-col>
                                <v-col
                                    cols="12"
                                    class="py-1"
                                >
                                    <v-text-field
                                        v-model="rowForm.boatName"
                                        :rules="boatNameRules"
                                        label="艇名"
                                        prepend-icon="mdi-sail-boat"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="6"
                                    class="py-1"
                                >
                                    <v-menu
                                        ref="menuOn"
                                        v-model="menuOn"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        :return-value.sync="rowForm.onTheWaterTime"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="rowForm.onTheWaterTime"
                                                label="艇庫発"
                                                prepend-icon="mdi-clock-time-four-outline"
                                                readonly
                                                required
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            v-if="menuOn"
                                            v-model="rowForm.onTheWaterTime"
                                            full-width
                                            @click:minute="$refs.menuOn.save(rowForm.onTheWaterTime)"
                                        ></v-time-picker>
                                    </v-menu>
                                </v-col>
                                <v-col
                                    cols="6"
                                    class="py-1"
                                >
                                    <v-menu
                                        ref="menuOff"
                                        v-model="menuOff"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        :return-value.sync="rowForm.offTheWaterTime"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="rowForm.offTheWaterTime"
                                                label="船台着"
                                                prepend-icon="mdi-clock-time-four-outline"
                                                readonly
                                                required
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            v-if="menuOff"
                                            v-model="rowForm.offTheWaterTime"
                                            full-width
                                            @click:minute="$refs.menuOff.save(rowForm.offTheWaterTime)"
                                        ></v-time-picker>
                                    </v-menu>
                                </v-col>
                                <v-col
                                    cols="6"
                                    class="py-1"
                                >
                                    <v-select
                                        v-model="rowForm.lowerLimitArea"
                                        :items="['1000G', '電線', '豊里', '赤川鉄橋', '毛馬']"
                                        label="下限水域"
                                        prepend-icon="mdi-arrow-collapse-down"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="6"
                                    class="py-1"
                                >
                                    <v-select
                                        v-model="rowForm.upperLimitArea"
                                        :items="['鳥飼', '島', '仁和寺', '新橋']"
                                        label="上限水域"
                                        prepend-icon="mdi-arrow-collapse-up"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    class="py-1"
                                >
                                    <v-text-field
                                        v-model="rowForm.others"
                                        label="その他"
                                        prepend-icon="mdi-pencil-plus-outline"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
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
            menuDate: false,
            menuOn: false,
            menuOff: false,
            rowForm: {
                date: new Date().toISOString().substr(0, 10),
                boatName: '',
                onTheWaterTime: null,
                offTheWaterTime: null,
                lowerLimitArea: '',
                upperLimitArea: '',
                others: '',
            },
            boatNameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            ],
        }),
        methods: {
            login () {
                console.log(this.rowForm)
            },
            async addRow () {
                // const response = await axios.post('/api/rows', {
                //     boat_name: this.rowForm.boatName,
                //     date_time: this.rowForm.date,
                // })
                console.log(this.rowForm)
                this.dialog = false
            }
        }
    }
</script>
