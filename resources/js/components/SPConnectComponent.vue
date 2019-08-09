<template>
    <div class="col-md-6 ">
        <div class="text-right py-2"><img src="/images/sendpulse-logo.svg"></div>
        <div class="card">
            <div class="text-center pb-4">
                <h1 class="h5 font-weight-bold">{{title}}</h1>
                <small>{{description}}
                    <a class="link" target="_blank" href="https://login.sendpulse.com/settings/#api">https://login.sendpulse.com/settings/#api</a>
                </small>
            </div>
            <div v-if="error" class="alert alert-warning  msg" role="alert">
                <span class="mdi mdi-bell-alert"></span> {{error}}
            </div>
            <div class="form-group pt-2">
                <label>SecretId</label>
                <input type="text" id="secretId" class="form-control" v-model="secretId">
            </div>
            <div class="form-group pt-2">
                <label>SecretKey</label>
                <input type="text" id="secretKey" class="form-control" v-model="secretKey">
            </div>
            <div class="text-center py-2">
                <button @click="save" class="btn btn-main" :disabled="sending">
                    <span v-if="sending" class="spinner-border spinner-border-sm" role="status"
                          aria-hidden="true"></span> {{btnConnectTitle}}
                </button>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        props: {
            title: String,
            description: String,
            btnConnectTitle: String,
        },

        data() {
            return {
                sending: false,
                secretId: null,
                secretKey: null,
                error: '',
            }
        },

        methods: {
            save() {
                this.sending = true;
                let currentObj = this;
                axios.post('/connect/set', {
                    secretId: this.secretId,
                    secretKey: this.secretKey,
                })
                    .then(response => {
                        console.log(response.data);
                        window.location.href = "/synсronization";
                    }).catch(e => {
                    console.log(e.response.data);
                    currentObj.error = e.response.data;
                    this.sending = false;
                });
            }
        }
    }
</script>
