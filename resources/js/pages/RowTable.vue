<template>
        <v-data-table
            :headers="headers"
            :items="rows"
            dense
            disable-pagination
            hide-default-footer
            class="elevation-1"
            mobile-breakpoint="10"
        >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>日付</v-toolbar-title>
                    <v-divider
                        class="mx-4"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>


                    <v-dialog
                        v-model="dialog"
                        max-width="640px"
                        form v-if="isLogin"
                    >
                        <template v-slot:activator="{ on, attrs }">
<!--                            <v-btn-->
<!--                                color="success"-->
<!--                                dark-->
<!--                                absolute-->
<!--                                top-->
<!--                                right-->
<!--                                fab-->
<!--                                v-bind="attrs"-->
<!--                                v-on="on"-->
<!--                            >-->
<!--                                <v-icon>mdi-plus</v-icon>-->
<!--                            </v-btn>-->
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                New Item
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









<!--                    <v-dialog-->
<!--                        v-model="dialog"-->
<!--                        max-width="500px"-->
<!--                    >-->
<!--                        <template v-slot:activator="{ on, attrs }">-->
<!--                            <v-btn-->
<!--                                color="primary"-->
<!--                                dark-->
<!--                                class="mb-2"-->
<!--                                v-bind="attrs"-->
<!--                                v-on="on"-->
<!--                            >-->
<!--                                New Item-->
<!--                            </v-btn>-->
<!--                        </template>-->
<!--                        <v-card>-->
<!--                            <v-card-title>-->
<!--                                <span class="headline">{{ formTitle }}</span>-->
<!--                            </v-card-title>-->
<!--                            <v-card-text>-->
<!--                                <v-container>-->
<!--                                    <v-text-field-->
<!--                                        v-model="editedItem.name"-->
<!--                                        label="Dessert name"-->
<!--                                    ></v-text-field>-->
<!--                                    <v-text-field-->
<!--                                        v-model="editedItem.calories"-->
<!--                                        label="Calories"-->
<!--                                    ></v-text-field>-->
<!--                                    <v-text-field-->
<!--                                        v-model="editedItem.fat"-->
<!--                                        label="Fat (g)"-->
<!--                                    ></v-text-field>-->
<!--                                    <v-text-field-->
<!--                                        v-model="editedItem.carbs"-->
<!--                                        label="Carbs (g)"-->
<!--                                    ></v-text-field>-->
<!--                                    <v-text-field-->
<!--                                        v-model="editedItem.protein"-->
<!--                                        label="Protein (g)"-->
<!--                                    ></v-text-field>-->
<!--                                </v-container>-->
<!--                            </v-card-text>-->

<!--                            <v-card-actions>-->
<!--                                <v-spacer></v-spacer>-->
<!--                                <v-btn-->
<!--                                    color="blue darken-1"-->
<!--                                    text-->
<!--                                    @click="close"-->
<!--                                >-->
<!--                                    Cancel-->
<!--                                </v-btn>-->
<!--                                <v-btn-->
<!--                                    color="blue darken-1"-->
<!--                                    text-->
<!--                                    @click="save"-->
<!--                                >-->
<!--                                    Save-->
<!--                                </v-btn>-->
<!--                            </v-card-actions>-->
<!--                        </v-card>-->
<!--                    </v-dialog>-->
<!--                    <v-dialog v-model="dialogDelete" max-width="500px">-->
<!--                        <v-card>-->
<!--                            <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>-->
<!--                            <v-card-actions>-->
<!--                                <v-spacer></v-spacer>-->
<!--                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>-->
<!--                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>-->
<!--                                <v-spacer></v-spacer>-->
<!--                            </v-card-actions>-->
<!--                        </v-card>-->
<!--                    </v-dialog>-->
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>
<!--            <template v-slot:no-data>-->
<!--                <v-btn-->
<!--                    color="primary"-->
<!--                    @click="initialize"-->
<!--                >-->
<!--                    Reset-->
<!--                </v-btn>-->
<!--            </template>-->
        </v-data-table>
</template>

<script>
    import {OK, UNPROCESSABLE_ENTITY} from '../util'

    export default {
        data: () => ({
            rows: [],
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
            // dialogDelete: false,
            headers: [
                {
                    text: '艇名',
                    align: 'start',
                    sortable: false,
                    value: 'boat_name',
                    width: "13%"
    },
                { text: '責任者', value: 'owner.name', width: "13%", sortable: false},
                { text: '艇庫発', value: 'on_the_water', width: "15%"},
                { text: '船台着', value: 'off_the_water', width: "15%"},
                { text: '下限水域', value: 'lower_limit_area', sortable: false, width: "15%"},
                { text: '上限水域', value: 'upper_limit_area', sortable: false, width: "15%"},
                { text: 'Actions', value: 'actions', sortable: false, width: "13%"},
            ],
            // desserts: [],
            // editedIndex: -1,
            // editedItem: {
            //     name: '',
            //     calories: 0,
            //     fat: 0,
            //     carbs: 0,
            //     protein: 0,
            // },
            // defaultItem: {
            //     name: '',
            //     calories: 0,
            //     fat: 0,
            //     carbs: 0,
            //     protein: 0,
            // },
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
            isLogin() {
                return this.$store.getters['auth/check']
            },
        },

        watch: {
            // dialog (val) {
            //     val || this.close()
            // },
            // dialogDelete (val) {
            //     val || this.closeDelete()
            // },

            $route: {
                async handler () {
                    await this.fetchRows()
                },
                immediate: true
            }
        },

        methods: {
            async fetchRows () {
                const response = await axios.get('/api/rows')

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                this.rows = response.data
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

                if (response.status !== OK) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }
                this.$router.go({path: this.$router.currentRoute.path, force: true})
            },

            // editItem (item) {
            //     this.editedIndex = this.desserts.indexOf(item)
            //     this.editedItem = Object.assign({}, item)
            //     this.dialog = true
            // },
            //
            // deleteItem (item) {
            //     this.editedIndex = this.desserts.indexOf(item)
            //     this.editedItem = Object.assign({}, item)
            //     this.dialogDelete = true
            // },
            //
            // deleteItemConfirm () {
            //     this.desserts.splice(this.editedIndex, 1)
            //     this.closeDelete()
            // },
            //
            // close () {
            //     this.dialog = false
            //     this.$nextTick(() => {
            //         this.editedItem = Object.assign({}, this.defaultItem)
            //         this.editedIndex = -1
            //     })
            // },
            //
            // closeDelete () {
            //     this.dialogDelete = false
            //     this.$nextTick(() => {
            //         this.editedItem = Object.assign({}, this.defaultItem)
            //         this.editedIndex = -1
            //     })
            // },
            //
            // save () {
            //     if (this.editedIndex > -1) {
            //         Object.assign(this.desserts[this.editedIndex], this.editedItem)
            //     } else {
            //         this.desserts.push(this.editedItem)
            //     }
            //     this.close()
            // },
        },
    }
</script>
