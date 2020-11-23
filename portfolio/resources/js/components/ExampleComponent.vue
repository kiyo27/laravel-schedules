<template>
    <div class="container">

        <b-input-group prepend="検索" class="mb-3">
            <b-form-input
                @input="search"
                v-model="keyword"
                type="search"
                class="no-focus"
            ></b-form-input>
        </b-input-group>

        <b-overlay :show="overlay" rounded="sm">
            <div class="row justify-content-center">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">今日の予定</div>
                            <Tasks
                                :items=itemsToday
                                @refresh="fetch"
                                @load="showOverlay"
                                :keyword=keyword
                            ></Tasks>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                <h2>その他の予定</h2>
                            </div>
                        </div>
                            <Tasks
                                :items=itemsOthers
                                @refresh="fetch"
                                @load="showOverlay"
                                :keyword=keyword
                            ></Tasks>
                    </div>
                </div>
            </div>
        </b-overlay>
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
            dataOthers: [],
            keyword: "",
            overlay: false,
        }
    },
    computed: {
        itemsToday: function() {
            return this.dataToday;
        },
        itemsOthers: function() {
            return this.dataOthers;
        },
    },
    mounted() {
        this.showOverlay();
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
            axios.get('/api/schedule?api_token='+window.apiToken)
            .then(res => {
                this.data = res.data;
                this.original = res.data;
                this.classify(this.data);
                this.hideOverlay();
            })
            .catch(error => {
                this.message = 'データの取得に失敗しました。';
                console.log(error);
                this.hideOverlay();
            });
        },
        classify: function(data) {
            const today = moment(new Date);
            this.dataToday = [];
            this.dataOthers = [];
            for (let i = 0; i < data.length; i++) {
                if (data[i].due_date === today.format('YYYY-MM-DD')) {
                    this.dataToday.push(data[i])
                } else {
                    this.dataOthers.push(data[i])
                }
            }
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
                // this.data = result;
                this.classify(result);
                this.hideOverlay();
            };
            this.showOverlay();
            setTimeout(s.bind(this),600)
        },
    }
}
</script>

<style lang="scss">
.card-header {
    display: flex;
    align-items: center;
    &-title {
        flex-grow: 2;
    }
    h2 {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
}

.no-focus:focus {
    box-shadow: none;
    outline: none;
    border-color: #cbcbcc;
}
</style>
