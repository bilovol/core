<template>
    <tr v-if="visible">
        <td>
            <div class="truncate">
                <button v-if="changed" @click="remove" type="button" class="btn btn-control btn-delete m-1">
                    <span class="mdi mdi-delete"></span>
                </button>
                {{event.title}}
            </div>
            <div v-if="error" class="alert alert-danger  error" role="alert">
                <span class="mdi mdi-bell-alert"></span> {{error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </td>
        <td>
            <select v-if="changed" class="form-control form-control-sm select-book" v-model="selectedBook">
                <option value="" disabled selected>---</option>
                <option v-for="book in books" v-bind:value="book.id" :disabled="book.status !== 0">
                    {{ book.name }}
                </option>
            </select>
            <span v-else class="select-book">{{ activeBookTitle }}</span>
        </td>
        <td class="text-right">
            <div class="chip chip-main">email</div>
            <div class="chip" v-for="field in selectedFields">{{ field.title }}
                <i v-if="changed" @click="unSelectField(field)" class="mdi mdi-close-circle"></i>
            </div>
            <button v-if="changed" type="button" class="btn btn-control ml-1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="mdi mdi-plus"></span>
            </button>
            <div class="dropdown-menu">
                <li class="dropdown-item" v-for="field in unselectedFields" @click="selectField(field)">
                    {{ field.title }}
                </li>
            </div>
            <button v-if="changed" @click="save()" type="button" class="btn btn-control btn-save ml-1">
                <span class="mdi mdi-content-save"></span>
            </button>
            <button v-else @click="edit()" type="button" class="btn btn-control ml-1">
                <span class="mdi mdi-pencil"></span>
            </button>
        </td>
    </tr>

</template>

<script>
    export default {
        props: {
            event: Object,//title,fields,activeBook
            books: Array,
            fields: Array,
        },

        data() {
            return {
                changed: false,
                availableFields: [],
                fieldsStorage: [],
                eventFields: this.event.fields,
                selectedBook: null,
                visible: true,
                error: null,
            }
        },

        created() {
            if (!this.event.fields) {
                this.changed = true;
                this.eventFields = [];
            }

            this.fieldsStorage = this.fields.map(a => {
                let newField = Object.assign({}, a);
                if (this.eventFields.indexOf(a.key) !== -1) {
                    newField.selected = true;
                }

                return newField;
            });

            this.selectedBook = this.event.activeBook;
        },

        computed: {
            selectedFields: function () {
                return this.fieldsStorage.filter(field => field.selected);
            },

            unselectedFields: function () {
                return this.fieldsStorage.filter(field => !field.selected);
            },
            activeBookTitle: function () {
                let selectedBook = this.books.filter(book => book.id === parseInt(this.selectedBook))[0];

                if (selectedBook) {
                    return selectedBook.name;
                } else {
                    return '---'
                }
            }
        },

        methods: {
            selectField(field) {
                this.$set(field, 'selected', true);
            },

            unSelectField(field) {
                this.$set(field, 'selected', false);
            },

            edit() {
                this.changed = true;
            },

            save() {
                let currentObj = this;
                axios.post('/synсronization/set', {
                    activeFields: this.fieldsStorage.filter(field => field.selected),
                    selectedBook: this.selectedBook,
                    eventId: this.event.id,
                    eventKey: this.event.key,
                    eventTitle: this.event.title,
                }).then(response => {
                    this.event.id = response.data;
                    console.log(response.data);
                    this.changed = false;
                }).catch(e => {
                    currentObj.error = e.response.data;
                    this.hideError();
                });
            },

            remove() {
                console.log('remove' + this.event.id);
                if (this.event.id) {
                    let currentObj = this;
                    axios.post('/synсronization/delete', {
                        eventId: this.event.id,
                    }).then(response => {
                        console.log(response.data);
                        this.visible = false;
                    }).catch(e => {
                        currentObj.error = e.response.data;
                        this.hideError();
                    });
                } else {
                    this.visible = false;
                }
            },

            hideError() {
                let currentObj = this;
                setTimeout(function () {
                    currentObj.error = null
                }, 3000);
            }

        }
    }
</script>
