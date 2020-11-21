<template>

    <div class="container">

        <b-modal id="modal-multi" ref="modal-multi-1" title="編集" scrollable hide-footer>

            <form ref="form" @submit.stop.prevent="doSend">
                <div>
                    <label>スケジュール</label>
                    <b-input-group class="mb-3">
                        <b-form-input
                            id="due-date-input"
                            v-model="dueDate"
                            type="text"
                            placeholder="YYYY-MM-DD"
                            autocomplete="off"
                        ></b-form-input>
                        <b-input-group-append>
                            <b-form-datepicker
                                v-model="dueDate"
                                button-only
                                right
                            ></b-form-datepicker>
                        </b-input-group-append>
                    </b-input-group>
                </div>
                <b-form-group label="件名">
                    <b-form-input
                        id="title-input"
                        v-model="title"
                    ></b-form-input>
                </b-form-group>
                <b-form-group label="内容">
                    <textarea
                        id="description-input"
                        v-model="description"
                        rows=7
                        class="form-control"
                    ></textarea>
                </b-form-group>

                <b-button v-b-modal.modal-multi-2 size="sm" variant="outline-danger">削除</b-button>
                <b-button type="submit" size="sm">更新</b-button>
            </form>

        </b-modal>

        <b-modal id="modal-multi-2" ref="modal-confirm-delelte" size="sm" hide-footer>
            <p class="my-1">削除してもよろしいですか？</p>
            <b-button size="sm" @click="hideModal('modal-confirm-delelte')">キャンセル</b-button>
            <b-button size="sm" @click="doDelete()" variant="outline-danger">削除</b-button>
        </b-modal>

        <div class="row row-cols">
            <div class="card col-sm-4" v-for="item in items" :key="item.id">
                <div class="card-body" @click="showModal(item)">
                    <h5 class="card-title">{{ item.title }}</h5>
                    <div>
                        <b-icon icon="calendar2-check"></b-icon>
                        <h6 class="card-subtitle mb-2 text-muted">{{ item.due_date }}</h6>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import { BootstrapVue, BModal, BButton, BFormDatepicker, BIcon, BIconCalendar2Check } from 'bootstrap-vue'
Vue.use(BootstrapVue)

export default {
    components: {
        BButton,
        BModal,
        BFormDatepicker,
        BIcon,
        BIconCalendar2Check
    },
    props: {
        items: {
            type: Array
        }
    },
    data() {
        return {
            modal: false,
            id: 0,
            dueDate: "",
            title: "",
            description: "",
        }
    },
    methods: {
        showModal(item) {
            this.id = item.id;
            this.dueDate = item.due_date;
            this.title = item.title;
            this.description = item.description;
            this.$refs['modal-multi-1'].show();
        },
        hideModal: function(...modals) {
            for (let i = 0; i < modals.length; i++) {
                // console.log(modals[i])
                this.$refs[modals[i]].hide()
            }
        },
        doDelete() {
            const data = {
                'id': this.id,
                'due_date': this.dueDate,
                'title': this.title,
                'description': this.description
            }
            this.$emit('load');
            this.hideModal('modal-confirm-delelte', 'modal-multi-1')
            axios.delete(
                '/api/schedule/'+data.id+'?api_token='+window.apiToken,
                data
            )
            .then(res => {
                this.$emit('refresh')
            })
            .catch(err => {
                console.log(err)
                this.$emit('error')
            })
        },
        doSend() {
            const data = {
                'id': this.id,
                'due_date': this.dueDate,
                'title': this.title,
                'description': this.description
            }
            this.$emit('load');
            this.hideModal('modal-multi-1')
            axios.put(
                '/api/schedule?api_token='+window.apiToken,
                data
            )
            .then(res => {
                this.$emit('refresh')
            })
            .catch(err => {
                console.log(err)
                this.$emit('error')
            })
        },

    }
}
</script>

<style lang="scss" scoped>
input, textarea {
    width: 100%;
}
.card {
    cursor: pointer;
}
.card-subtitle {
    display: inline;
}
</style>
