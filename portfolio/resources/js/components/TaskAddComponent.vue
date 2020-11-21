<template>
    <div>
        <div @click="openModal" class="h2 mb-0 plus plus-btn">
            <b-icon icon="plus-circle-fill" variant="primary" font-scale="1.5"></b-icon>
        </div>

        <b-modal id="modal-add" ref="modal-add" title="新しい予定" scrollable hide-footer>

            <form ref="form" @submit.stop.prevent="doSend">
                <div>
                    <label for="due-date-input">スケジュール</label>
                    <b-form-datepicker id="due-date-input" v-model="dueDate" class="mb-2"></b-form-datepicker>
                </div>
                <b-form-group
                label="件名"
                label-for="title-input"
                >
                    <b-form-input
                        id="title-input"
                        v-model="title"
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                label="内容"
                label-for="description-input"
                >
                    <textarea
                        id="description-input"
                        v-model="description"
                        rows=7
                        class="form-control"
                    ></textarea>
                </b-form-group>

                <b-button type="form" size="sm">登録</b-button>
            </form>

        </b-modal>
    </div>
</template>

<script>
import { BootstrapVue, BIcon, BIconPlusCircleFill } from 'bootstrap-vue'
Vue.use(BootstrapVue)

export default {
    components: {
        BIcon,
        BIconPlusCircleFill,
    },
    data() {
        return {
            dueDate: "",
            title: "",
            description: "",
        }
    },
    methods: {
        openModal() {
            this.$refs['modal-add'].show();
        },
        closeModal: function() {
            this.$refs['modal-add'].hide();
        },
        doSend() {
            this.$emit('load');
            this.closeModal();
            axios.post('/api/schedule?api_token='+window.apiToken, {
                dueDate: this.dueDate,
                title: this.title,
                description: this.description
            })
            .then(res => {
                this.closeModal();
                this.$emit('refresh');
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.plus {
    position: fixed;
    bottom: 10px;
    right: 10px;
    z-index: 10;
    &-btn {
        cursor: pointer;
    }
}

input, textarea {
    width: 100%;
}
</style>
