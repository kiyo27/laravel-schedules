<template>

<div>
    <form ref="form" @submit.stop.prevent="doSend">
        <div>
            <label>スケジュール</label>
            <b-input-group class="mb-3">
                <b-form-input
                    v-model="inputDueDate"
                    type="text"
                    placeholder="YYYY-MM-DD"
                    autocomplete="off"
                ></b-form-input>
                <b-input-group-append>
                    <b-form-datepicker
                        v-model="inputDueDate"
                        button-only
                        right
                    ></b-form-datepicker>
                </b-input-group-append>
            </b-input-group>
        </div>
        <b-form-group label="件名">
            <b-form-input
                v-model="inputTitle"
            ></b-form-input>
        </b-form-group>
        <b-form-group label="内容">
            <textarea
                v-model="inputDescription"
                rows=7
                class="form-control"
            ></textarea>
        </b-form-group>

        <slot name="footer">
            <b-button @click="showDeleteModal" size="sm" variant="outline-danger">削除</b-button>
            <b-button type="submit" size="sm">更新</b-button>
        </slot>

    </form>

    <b-modal id="modal-multi-2" ref="modal-confirm-delelte" size="sm" hide-footer>
        <p class="my-1">削除してもよろしいですか？</p>
        <b-button size="sm" @click="hideModal('modal-confirm-delelte')">キャンセル</b-button>
        <b-button size="sm" @click="doDelete()" variant="outline-danger">削除</b-button>
    </b-modal>
</div>

</template>

<script>
export default {
    props: {
        id: {
            type: Number
        },
        dueDate: {
            type: String
        },
        title: {
            type: String
        },
        description: {
            type: String
        },
    },
    data() {
        return {
            inputDueDate: this.dueDate,
            inputTitle: this.title,
            inputDescription: this.description,
        }
    },
    methods: {
        showDeleteModal() {
            this.$refs['modal-confirm-delelte'].show();
        },
        hideModal: function(...modals) {
            for (let i = 0; i < modals.length; i++) {
                this.$refs[modals[i]].hide()
            }
        },
        doSend() {
            let data = {
                'due_date': this.inputDueDate,
                'title': this.inputTitle,
                'description': this.inputDescription
            }

            if (this.id != 0) {
                data.id = this.id;
                this.update(data);
            } else {
                this.create(data);
            }
        },
        update: function(param) {
            this.$emit('update', param);
            this.$emit('close');
        },
        create: function() {
            const param = {
                dueDate: this.inputDueDate,
                title: this.inputTitle,
                description: this.inputDescription,
            };
            this.$emit('create', param);
            this.$emit('close');
        },
        doDelete() {
            this.hideModal('modal-confirm-delelte');
            this.$emit('delete', this.id);
        },
    }
}
</script>
