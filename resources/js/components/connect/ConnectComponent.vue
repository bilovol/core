<template>
    <section class="pt-4">
        <div class="row justify-content-center">
            <div v-if="loading" class="text-center">
                <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div v-else class="card col-md-6">
                <div class="text-center pb-4">
                    <h5>{{title}}</h5>
                    <small id="SecretId" class="form-text text-muted">
                        {{description}}
                        <a class="link" target="_blank" href="https://login.sendpulse.com/settings/#api">https://login.sendpulse.com/settings/#api</a>
                    </small>
                </div>
                <div class="form-group pt-2">
                    <label>SecretId</label>
                    <input v-on:input="changed" type="text" class="form-control" placeholder="SecretId"
                           v-model="secretId">
                </div>
                <div class="form-group pt-2">
                    <label>SecretKey</label>
                    <input v-on:input="changed" type="text" class="form-control" placeholder="SecretKey"
                           v-model="secretKey">
                </div>
                <div class="text-right py-3">
                    <button @click="save" class="btn btn-secondary">{{btnTitle}}</button>
                </div>
            </div>
        </div>

    </section>
</template>

<script>

    export default {
        props: {
            title: String,
            description: String,
            btnCheckConnectTitle: String,
            btnSaveTitle: String,
        },

        data() {
            return {
                loading: true,
                secretId: null,
                secretKey: null,
                btnTitle: this.btnCheckConnectTitle,
            }
        },

        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/connect/get')
                    .then(response => {
                            this.secretId = response.data.secretId;
                            this.secretKey = response.data.secretKey;
                        }
                    ).catch(function (e) {
                    console.log(e.response);
                });
                this.loading = false;
            },

            changed: function () {
                this.btnTitle = this.btnSaveTitle;
            },

            save() {
                axios.post('/connect/set', {
                    secretId: this.secretId,
                    secretKey: this.secretKey,
                }).then(function (response) {
                    console.log(response.data);
                }).catch(function (e) {
                    console.log(e.response.data);
                    if (e.response.status === 500) {
                        e.response.data = 'Internal Server Error';
                    }
                });
            }
        }
    }
</script>
<style>
    .card {
        border: none;
        padding: 3rem;
        border-radius: 7px;
    }
</style>
