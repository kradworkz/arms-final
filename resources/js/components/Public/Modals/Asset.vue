<template>
    <div class="modal fade exampleModal" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Asset</h5>
                     <button type="button" @click="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="text-lg-center">
                                <img class="rounded avatar-xl" :src="currentUrl+'/images/avatars/'+asset.image" alt="">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div>
                                <a class="d-block text-primary mb-2">#{{asset.asset}}</a>
                                <h5 class="text-truncate mb-2">{{asset.name}} 
                                    <span :class="'badge badge-soft-'+asset.status.color+' ml-1 font-size-12'">{{asset.status.name}}</span>
                                </h5>
                                <p class="mb-4 mb-lg-4">Tracker : {{asset.tracker}}</p>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <h5 class="font-size-14" data-toggle="tooltip" data-placement="top" title="" data-original-title="Due Date"><i class='bx bxs-map mr-2'></i>{{asset.location}}</h5>
                                    </li>
                                </ul>
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
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                asset: {
                    status: {}
                }
            }
        },

        methods : {
            open(asset){
                this.asset = asset;
                $("#view").modal('show');
            },

            close(){
                this.$emit('status',{size : 12, coor: this.asset.coordinates});
            }
        }
    }
</script>
