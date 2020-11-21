<template>
    <div class="container">
        <b-input-group prepend="検索" class="mb-3">
            <b-form-input @input="search" v-model="keyword" type="search"></b-form-input>
        </b-input-group>

        <TaskAdd
            @refresh="fetch"
            @load="showOverlay"
        ></TaskAdd>

        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">今日の予定</div>
                        <Tasks
                            :items=itemsToday
                            @refresh="fetch"
                            @load="showOverlay"
                        ></Tasks>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <b-overlay :show="overlay" rounded="sm">
                    <div class="card">
                        <div class="card-header">予定一覧</div>
                            <Tasks
                                :items=items
                                @refresh="fetch"
                                @load="showOverlay"
                            ></Tasks>
                    </div>
                </b-overlay>
            </div>
        </div>
    </div>
</template>

<script>
import Tasks from './TasksComponent'
import TaskAdd from './TaskAddComponent'

export default {
    components: {
        Tasks,
        TaskAdd
    },
    data() {
        return {
            original: [],
            data: [],
            dataToday: [],
            keyword: "",
            overlay: false,
        }
    },
    computed: {
        items: function() {
            return this.data;
        },
        itemsToday: function() {
            return this.dataToday;
        }
    },
    mounted() {
        this.fetch();
    },
    methods: {
        showOverlay: function() {
            this.overlay = true;
        },
        hideOverlay: function() {
            this.overlay = false;
        },
        fetch: function() {
            this.showOverlay();
            axios.get('/api/schedule?api_token='+window.apiToken)
            .then(res => {
                this.data = res.data;
                this.original = res.data;
                this.extractToday();
                this.hideOverlay();
            })
            .catch(error => {
                this.message = 'データの取得に失敗しました。';
                console.log('error');
                this.hideOverlay();
            });
        },
        extractToday: function() {
            this.dataToday = this.data.filter(function(data) {
                const today = moment(new Date)
                return data.due_date === today.format('YYYY-MM-DD')
            })

        },
        sort: function() {
            this.data.sort(function(first, second) {
                if (first.due_date > second.due_date) {
                    return -1;
                } else {
                    return 1;
                }
            });
        },
        search: function(event) {
            const s = function () {
                const kwd = {
                    'kwd': this.keyword
                }

                const result = this.original.filter(function(data) {
                    const regex = RegExp(this.kwd);
                    return regex.test(data.title) || regex.test(data.description);
                }, kwd)
                this.data = result;
                this.hideOverlay();
            };
            this.showOverlay();
            setTimeout(s.bind(this),700)
        },
    }
}
</script>
