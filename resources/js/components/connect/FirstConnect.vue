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
            <div class="form-group pt-2">
                <label>SecretId</label>
                <input type="text" class="form-control" placeholder="SecretId"  v-model="secretId">
            </div>
            <div class="form-group pt-2">
                <label>SecretKey</label>
                <input type="text" class="form-control" placeholder="SecretKey"  v-model="secretKey">

            </div>
            <div class="text-center pt-2">
                <button @click="save" class="btn btn-main">{{btnConnectTitle}}</button>
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
                loading: true,
                secretId: null,
                secretKey: null,
            }
        },

        methods: {
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
