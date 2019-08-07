<template>
    <tr>
        <td>
            <div class="truncate">
                <button v-if="changed" @click="remove" type="button" class="btn btn-control btn-delete m-1">
                    <span class="mdi mdi-delete"></span>
                </button>
                {{event.title}}
            </div>
        </td>
        <td>
            <select v-if="changed" class="form-control form-control-sm select-book">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
            <span v-else class="select-book">Книга</span>
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
            books: Object,
            fields: Array,
        },

        data() {
            return {
                loading: false,
                changed: false,
                availableFields: [],
                fieldsStorage: [],
                eventFields: this.event.fields,
            }
        },
        created() {
            console.log(this.event.fields);
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

        },
        computed: {
            selectedFields: function () {
                return this.fieldsStorage.filter(field => field.selected);
            },
            unselectedFields: function () {
                return this.fieldsStorage.filter(field => !field.selected);
            }
        },

        methods: {
            selectField(field) {
                field.selected = true;
            },
            unSelectField(field) {
                field.selected = false;
            },
            edit() {
                this.changed = true;
            },
            save() {
                axios.post('/synсronization/set', {
                    activeFields: this.fieldsStorage.filter(field => field.selected),
                    activeBook: this.activeBook,
                    title: this.title,
                }).then(response => {
                    console.log(response);
                }).catch(e => {
                    console.log(e.response);
                });

                this.changed = false;
            },
            remove() {
                this.event.splice(1, 1);
            }

        }
    }
</script>
