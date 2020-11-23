<template>

    <div class="container">
        <b-modal id="modal-multi" ref="modal-multi-1" title="編集" scrollable hide-footer>
            <TaskModal
                :id=id
                :dueDate=dueDate
                :title=title
                :description=description
                @close="hideModal"
                @update="update"
                @delete="doDelete"
            ></TaskModal>
        </b-modal>

        <b-modal id="modal-add" ref="modal-add" title="新しい予定" scrollable hide-footer>
            <TaskModal
                :id=0
                @close="hideAddModal"
                @create="create"
            >
                <template slot="footer">
                    <b-button type="submit" size="sm">登録</b-button>
                </template>
            </TaskModal>
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
            <template v-if="keyword === ''">
                <div class="card col-sm-4 card-add" @click="showAddModal">
                    <div class="card-body">
                        <h5 class="card-title invisible">no title</h5>
                        <div class="invisible">
                            <b-icon icon="calendar2-check"></b-icon>
                            <h6 class="card-subtitle mb-2 text-muted"></h6>
                        </div>
                    </div>
                    <div class="card-add-icon">
                        <b-icon icon="plus" font-scale="1.5"></b-icon>
                    </div>
                </div>
            </template>
        </div>

    </div>

</template>

<script>
import {
    BootstrapVue,
    BModal,
    BButton,
    BFormDatepicker,
    BIcon,
    BIconCalendar2Check,
    BIconPlus,
} from 'bootstrap-vue'

import TaskModal from './TaskModalComponent'

Vue.use(BootstrapVue)

export default {
    components: {
        BButton,
        BModal,
        BFormDatepicker,
        BIcon,
        BIconCalendar2Check,
        BIconPlus,
        TaskModal,
    },
    props: {
        items: {
            type: Array
        },
        keyword: {
            type: String
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
        showAddModal() {
            this.$refs['modal-add'].show();
        },
        showModal(item) {
            this.id = item.id;
            this.dueDate = item.due_date;
            this.title = item.title;
            this.description = item.description;
            this.$refs['modal-multi-1'].show();
        },
        hideAddModal: function() {
            this.$refs['modal-add'].hide();
        },
        hideModal: function() {
            this.$refs['modal-multi-1'].hide();
        },
        create: function(param) {
            this.hideModal();
            this.$emit('load');
            axios.post('/api/schedule?api_token='+window.apiToken, param)
            .then(res => {
                this.$emit('refresh');
            })
            .catch(error => {
                this.errorHandling();
            });
        },
        update: function(data) {
            this.hideModal();
            this.$emit('load');
            axios.put(
                '/api/schedule?api_token='+window.apiToken,
                data
            )
            .then(res => {
                this.$emit('refresh');
            })
            .catch(error => {
                this.errorHandling();
            });
        },
        doDelete: function(id) {
            this.hideModal();
            this.$emit('load');
            axios.delete(
                '/api/schedule/' + id + '?api_token='+window.apiToken,
            )
            .then(res => {
                this.$emit('refresh');
            })
            .catch(err => {
                this.errorHandling();
            })
        },
        errorHandling: function() {
            alert('通信エラーが発生しました。')
        }
    }
}
</script>

<style lang="scss" scoped>
input, textarea {
    width: 100%;
}
.card {
    cursor: pointer;
    &-add {
        position: relative;
        &-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
}
.card-subtitle {
    display: inline;
}
.invisible {
    visibility: hidden;
}
</style>
