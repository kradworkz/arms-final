<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="media">
                        <div class="mr-3">
                            <img v-if="asset.image != undefined" :src="currentUrl+'/images/avatars/'+asset.image" alt="" class="avatar-md rounded-circle img-thumbnail">
                        </div>
                        <div class="media-body align-self-center">
                            <div class="text-muted font-weight-bold">
                                <p class="text-primary mb-2">{{asset.location.name}}</p>
                                <h5 class="text-success mb-1">{{asset.name}}</h5>
                                <p class="mb-0">{{asset.category}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-self-center">
                    <div class="text-lg-center mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Quantity</p>
                                    <h5 class="mb-0">{{asset.quantity}}</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">Available</p>
                                    <h5 class="mb-0">{{asset.available}}</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <p class="text-muted text-truncate mb-2">With Tracker</p>
                                    <h5 class="mb-0">{{asset.tracker}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['assetId'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                asset: { location: {}},
            }
        },

        created(){
            this.fetch();
        },

        methods : {
            fetch(){
                axios.get(this.currentUrl + '/request/member/asset/'+this.assetId)
                .then(response => {
                    this.asset = response.data.data;
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>
