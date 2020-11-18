<template>

    <div class="container">

        <TaskModal @close="closeModal" v-if="modal">
            <!-- default スロットコンテンツ -->
            <p>Edit</p>
            <div>
                <label>Due date</label>
                <input v-model="dueDate">
            </div>
            <div>
                <label>Title</label>
                <input v-model="title">
            </div>
            <div>
                <label>Description</label>
                <textarea v-model="description"></textarea>
            </div>
            <!-- /default -->
            <!-- footer スロットコンテンツ -->
            <template slot="footer">
                <button @click="doSend">Update</button>
            </template>
            <!-- /footer -->
        </TaskModal>

        <DeleteConfirmModal>
            <p>削除しますか？</p>
        </DeleteConfirmModal>

        <div class="row row-cols">
            <div class="card col-sm-4" v-for="item in items" :key="item.id">
                <div class="card-body">
                    <h5 class="card-title">{{ item.title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ item.due_date }}</h6>
                    <p class="card-text">{{ item.description }}</p>
                    <a class="card-link" @click="openModal(item)">Edit</a>
                    <a class="card-link">Delete</a>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import TaskModal from './TaskModalComponent'

export default {
    components: {
        TaskModal
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
            description: ""
        }
    },
    methods: {
        openModal(item) {
            this.modal = true
            this.id = item.id
            this.dueDate = item.due_date
            this.title = item.title
            this.description = item.description
        },
        closeModal: function() {
            this.modal = false
        },
        doSend() {
            const data = {
                'id': this.id,
                'due_date': this.dueDate,
                'title': this.title,
                'description': this.description
            }
            axios.put(
                '/api/schedule?api_token='+window.apiToken,
                data
            )
            .then(res => {
                this.closeModal()
                this.$emit('refresh')
            })
            .catch(err => {
                console.log(err)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
input, textarea {
    width: 100%;
}
</style>
