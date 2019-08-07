<template>
    <section class="pt-4">
        <div v-if="loading" class="text-center">
            <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div class="col-12 pb-4">
                <button v-for="event in events" @click="selectEvent(event)" type="button" class="btn btn-tab"
                        v-bind:class="{ active : event===activeEvent }">
                    {{ event.title }}
                </button>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Поля для экспорта</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="field in selectedFields">
                    <td>
                        <div class="truncate">
                            {{field.title}}
                        </div>
                    </td>

                    <td class="text-right">
                        <button @click="removeField(field)" type="button" class="btn btn-control btn-delete m-1">
                            <span class="mdi mdi-delete"></span>
                        </button>
                    </td>
                </tr>
                <button type="button" class="btn btn-secondary float-left" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <span class="mdi mdi-plus"></span> Добавить событие
                </button>
                <div class="dropdown-menu">
                    <li v-for="field in unselectedFields" class="dropdown-item" @click="selectField(field)">
                        {{ field.title }}
                    </li>
                </div>

                </tbody>
            </table>
        </div>

    </section>
</template>

<script>

    export default {
        data() {
            return {
                loading: true,
                books: [],
                fields: [],
                events: [],//all events
                activeEvent: {
                    fields: []
                },
            }
        },

        created() {
            this.fetchData();
        },

        computed: {
            selectedFields: function () {
                return this.activeEvent.fields.filter(field => field.selected);
            },
            unselectedFields: function () {
                return this.activeEvent.fields.filter(field => !field.selected);
            }
        },

        methods: {
            fetchData() {
                axios.get('/export/get')
                    .then(response => {
                            this.events = response.data.events;
                            this.selectEvent(this.events[0]);
                            this.books = response.data.books;
                        }
                    ).catch(function (e) {
                    console.log(e.response);
                });
                this.loading = false;
            },

            selectEvent(event) {
                this.activeEvent = event;
                // this.fields = event.fields;
                console.log(event);
            },

            removeField(field) {
                field.selected = false;
            },
            selectField(field) {
                field.selected = true;
            }
        }
    }
</script>
