<template>
    <section class="pt-4">
        <div v-if="loading" class="text-center">
            <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else class="card">
            <div class="form-group">
                <small class="form-text text-muted">{{gistsDescription}}</small>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text">{{gistsTitle}}</label>
                    </div>
                    <select class="custom-select" v-model="activeEvent">
                        <option value="" disabled selected>---</option>
                        <option v-for="event in events" v-bind:value="event">{{event.title}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <small class="form-text text-muted">{{booksDescription}}
                </small>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text">{{booksTitle}}</label>
                    </div>
                    <select class="custom-select" v-model="selectedBook">
                        <option value="" disabled selected>---</option>
                        <option v-for="book in books" v-bind:value="book.id" :disabled="book.status !== 0">
                            {{ book.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <small class="form-text text-muted">{{fieldsTitle}}</small>
                <div class="mb-3">
                    <div class="chip chip-main">email</div>
                    <div v-for="field in selectedFields" class="chip">{{field.title}} <i @click="removeField(field)"
                                                                                         class="mdi mdi-close-circle"></i>
                    </div>
                    <button type="button" class="btn btn-control ml-1" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="mdi mdi-plus"></span>
                    </button>
                    <div class="dropdown-menu">
                        <li v-for="field in unselectedFields" class="dropdown-item" @click="selectField(field)">
                            {{ field.title }}
                        </li>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button @click="sendForm" :disabled="sending" type="button" class="btn btn-secondary"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <span v-if="sending" class="spinner-border spinner-border-sm" role="status"
                          aria-hidden="true"></span>
                    {{btnTitle}}
                </button>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        props: {
            gistsDescription: String,
            gistsTitle: String,
            booksDescription: String,
            booksTitle: String,
            fieldsTitle: String,
            btnTitle: String,

        },
        data() {
            return {
                loading: true,
                sending: false,
                books: [],
                selectedBook: '',
                events: [],
                activeEvent: {
                    fields: []
                },
            }
        },

        created() {
            this.fetchData();
        },

        computed: {
            selectedFields() {
                return this.activeEvent.fields.filter(field => field.selected);
            },


            unselectedFields() {
                return this.activeEvent.fields.filter(field => !field.selected);
            },

        },

        methods: {
            fetchData() {
                axios.get('/export/get').then(response => {
                    this.events = response.data.events;
                    this.books = response.data.books;
                    this.selectEvent(this.events[0]);
                    this.loading = false;
                }).catch(function (e) {
                    console.log(e.response);
                    this.loading = false;
                });
            },

            sendForm() {
                this.sending = true;
                axios.post('/export/set', {
                    event: this.activeEvent,
                    selectedBook: this.selectedBook,
                }).then(response => {
                    console.log(response.data);
                    this.sending = false;
                }).catch(e => {
                    console.log(e.response.data);
                    this.sending = false;
                });
            },

            selectEvent(event) {
                this.activeEvent = event;
            },

            removeField(field) {
                this.$set(field, 'selected', false);
            },

            selectField(field) {
                this.$set(field, 'selected', true);
            },
        }
    }
</script>
<style>
    .btn-control-disabled {
        color: #616A70;
    }
</style>
