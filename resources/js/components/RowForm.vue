<template>
    <v-row justify="center">
        <v-alert
            text
            type="error"
            v-if="rowErrors">
            不正な入力です
        </v-alert>
        <v-dialog
            v-model="dialog"
            max-width="640px"
            form v-if="isLogin"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-card-text style="position: relative">
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
                                                :rules="rules.required"
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
                                        :rules="rules.boatName"
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
                                                :rules="rules.required"
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
                                                :rules="rules.required"
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
                                        :rules="rules.required"
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
                                        :rules="rules.required"
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
                                        :rules="rules.others"
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
    import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

    export default {
        data: () => ({
            rowErrors: null,
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
            rules: {
                boatName: [
                    v => !!v || '艇名を入力してください',
                    v => (v && v.length <= 8) || '艇名は8文字以下で入力してください',
                ],
                others: [
                    v => (v && v.length <= 24) || '24文字以下で入力してください',
                ],
                required: [
                    v => !!v || '入力してください',
                ],
            },
        }),
        methods: {
            login () {
                console.log(this.rowForm)
            },
            async addRow () {
                this.dialog = false

                const response = await axios.post('/api/rows', {
                    date_time: this.rowForm.date,
                    boat_name: this.rowForm.boatName,
                    on_the_water: this.rowForm.onTheWaterTime,
                    off_the_water: this.rowForm.offTheWaterTime,
                    lower_limit_area: this.rowForm.lowerLimitArea,
                    upper_limit_area: this.rowForm.upperLimitArea,
                    others: this.rowForm.others,
                })

                // バリデーションエラー
                if (response.status === UNPROCESSABLE_ENTITY) {
                    this.rowErrors = response.data.errors
                    console.log(this.rowErrors)
                    return false
                }

                // エラーメッセージをクリア
                this.rowErrors = null

                if (response.status !== CREATED) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

            }
        },
        computed: {
            isLogin() {
                return this.$store.getters['auth/check']
            }
        }
    }
</script>
