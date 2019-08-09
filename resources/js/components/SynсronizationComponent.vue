<template>
    <section class="pt-4">
        <div v-if="loading" class="text-center">
            <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-else>
            <table v-if="activeEvents !== null" class="table">
                <thead>
                <tr>
                    <th scope="col">{{ tableEventTitle }}</th>
                    <th scope="col">{{ tableBookTitle }}</th>
                    <th scope="col" class="text-right">{{ tableFieldsTitle }}</th>
                </tr>
                </thead>
                <tbody>
                <sync-item
                    v-for="event in activeEvents"
                    :key="event.id"
                    v-bind:event="event"
                    v-bind:books="books"
                    v-bind:fields="fields"
                ></sync-item>
                </tbody>
            </table>
        </div>
        <div v-if="!loading" class="pt-3">
            <button type="button" class="btn btn-secondary float-left" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="mdi mdi-plus"></span> {{ btnAddEventTitle }}
            </button>
            <div class="dropdown-menu">
                <li v-for="event in events" class="dropdown-item" @click="selectEvent(event)">
                    {{ event.title }}
                </li>
            </div>
        </div>
    </section>
</template>

<script>
    import SyncItem from "./SyncItem";

    export default {
        components: {SyncItem},

        props: {
            tableEventTitle: String,
            tableBookTitle: String,
            tableFieldsTitle: String,
            btnAddEventTitle: String,
            booksSelectTitle: String,
        },

        data() {
            return {
                loading: true,
                books: [],
                fields: [],
                activeEvents: null,
                events: [],//all events
                toast: null,
            }
        },

        created() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                let currentObj = this;
                axios.get('/synсronization/get').then(response => {
                    this.events = response.data.events;
                    this.activeEvents = response.data.activeEvents;
                    this.fields = response.data.fields;
                    this.books = response.data.books;
                    this.loading = false;
                }).catch(function (e) {
                    currentObj.loading = false;
                    console.log(e.response);
                });
            },

            selectEvent(event) {
                this.activeEvents.push(event)
            },
        }
    }
</script>
