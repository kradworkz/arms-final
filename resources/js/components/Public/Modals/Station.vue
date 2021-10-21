<template>
    <div class="modal fade exampleModal" id="station" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{station.name}}</h5>
                     <button type="button" @click="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                       <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr class="">
                                            <th>Code</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">View Details</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="table-responsive" data-simplebar style="max-height: 300px; min-height: 300px;">
                                <table class="table table-centered table-nowrap mb-0">
                                    <tbody>
                                        <tr v-for="(asset,index) in assets" v-bind:key="asset.id">
                                            <td><a class="text-body font-weight-bold">{{asset.code}}</a></td>
                                            <td class="text-center">{{asset.name}}</td>
                                            <td class="text-center">{{asset.category}}</td>
                                            <td class="text-center"><span :class="'badge badge-pill badge-soft-'+asset.status.color+' font-size-12'">{{asset.status.name}}</span></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-toggle="modal" data-target=".exampleModal">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                pagination: {},
                assets : [],
                station: {}
            }
        },

        methods : {
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                let vm = this; let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                page_url = page_url || this.currentUrl + '/pub/assets/lists/'+this.station.id+'/'+key;
                axios.get(page_url)
                .then(response => {
                    this.assets = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },
            
            open(marker){
                this.station = marker;
                $("#station").modal('show');
                this.fetch();
            },

            close(){
                this.$emit('status',{size : 12, coor: this.station.coordinates});
            }
        }
    }
</script>
