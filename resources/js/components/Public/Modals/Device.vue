<template>
    <div class="modal fade exampleModal" id="view2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <span :class="'badge badge-soft-'+device.status.color+' ml-1 font-size-12'">{{device.status.name}}</span>
                     <button type="button" @click="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <h5 class="text-truncate mb-2">{{device.station}}</h5>
                                <p class="text-muted font-size-14">{{device.municipality.name}} {{device.province.name}}</p>
                              
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <h5 class="font-size-12"><i class='bx bxs-chip mr-2'></i>{{device.type.name}}</h5>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="font-size-12"><i class='bx bxs-data mr-2'></i>Datalogger : {{device.datalogger}}</h5>
                                    </li>
                                </ul>
                                <blockquote class="blockquote mt-2">
                                    <footer class="blockquote-footer"><cite title="Source Title">{{device.remarks}}</cite></footer>
                                </blockquote>
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
                device: {
                    status: {},
                    type: {},
                    municipality: {},
                    province: {}
                }
            }
        },

        methods : {
            open(device){
                this.device = device;
                $("#view2").modal('show');
            },

            close(){
                this.$emit('status',{size : 12, coor: this.asset.coordinates});
            }
        }
    }
</script>
