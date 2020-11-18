<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Schedule</div>

                        <Tasks
                            :items=items
                            @refresh="fetch"
                        >
                        </Tasks>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tasks from './TasksComponent'
export default {
    components: {
        Tasks,
    },
    data() {
        return {
            data: [],
        }
    },
    computed: {
        items: function() {
            return this.data
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch: function() {
            axios.get('/api/schedule?api_token='+window.apiToken)
            .then(res => {
                this.data = res.data;
            })
            .catch(error => {
                this.message = 'データの取得に失敗しました。';
                console.log('error')
            });
        }
    }
}
</script>
