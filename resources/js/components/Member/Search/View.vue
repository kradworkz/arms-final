<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-6">
                    <h4>{{asset.name}} <span :class="'badge badge-'+stat.color+' font-size-12 ml-2'"> {{stat.name}}</span></h4>
                    <p class="text-muted" style="margin-top: -8px; margin-bottom: -10px;"><i class="bx bx-calendar-plus font-size-12 align-middle text-primary mr-1"></i><span class="font-size-11">{{asset.created_at}}</span></p>
                </div>
                <search-buttons @res="update" :user="user" :asset="asset" :statuz="stat.name"></search-buttons>
            </div>
            <div class="modal-body mb-4">
                <div class="row ml-3 mr-3 mt-3 mb-3">
                    <div class="col-xl-5">
                        <div class="d-flex flex-wrap mb-2">
                            <div class="avatar-sm mr-3">
                                <div class="avatar-title bg-light rounded-circle font-size-20" v-bind:class="[(asset.availability == 'Available' ? 'text-success' : 'text-danger')]">
                                    <i v-bind:class="[(asset.availability == 'Available' ? 'bx bxs-check-circle' : 'bx bxs-x-circle')]"></i>
                                </div>
                            </div>
                            <h4 class="mb-0 mt-3" v-bind:class="[(asset.availability == 'Available' ? 'text-success' : 'text-danger')]">{{asset.availability}}</h4>
                        </div>
                        <hr></hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="font-size-12"><i class="bx bx-barcode-reader mr-1 text-primary"></i> Asset Code</h6>
                                <p class="text-primary font-weight-bold mb-0">#{{asset.asset_code}}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="font-size-12"><i class="bx bx-code mr-1 text-primary"></i>Tracket Code</h6>
                                <p class="text-muted mb-0">{{ (asset.tracker_code == '') ? 'no tracker set' : asset.tracker_code}}</p>
                            </div>
                        </div>
                        <hr></hr>
                        <div class="row task-dates">
                            <div class="col-sm-6">
                                <h6 class="font-size-12"><i class="bx bx-calendar mr-1 text-primary"></i> Maintenance</h6>
                                <p class="text-muted mb-0">{{asset.maintenance}}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="font-size-12"><i class="bx bx-calendar-x mr-1 text-primary"></i>Expiration</h6>
                                <p class="text-muted mb-0">{{ asset.expiry}}</p>
                            </div>
                        </div>
                        <hr></hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted"><i class="bx bx-category font-size-12 align-middle text-primary mr-1"></i> {{ asset.category}}</p>
                                <p class="text-muted" style="margin-top: -10px;"><i class="bx bx-map-pin font-size-12 align-middle text-primary mr-1"></i> {{ asset.location}}</p>
                                <p class="text-muted" style="margin-top: -10px;"><i class="bx bx-map-alt font-size-12 align-middle text-primary mr-1"></i> {{asset.address}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="float-right" style="margin-top: -10px;" v-if="lagss.length > 0">
                            <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                                <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.from}}-{{pagination.to}} of {{pagination.total}} </li>
                                <li class="list-inline-item d-none d-sm-inline-block">
                                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                                        <i class='bx bxs-chevron-left font-size-16'></i>
                                    </a>
                                </li>
                                <li class="list-inline-item d-none d-sm-inline-block">
                                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                                        <i class='bx bxs-chevron-right font-size-16'></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <h4 class="card-title mb-4">Asset Logs</h4>
                        <div data-simplebar style="max-height: 300px; min-height: 300px;">
                            <div class="col-md-12 align-center" style="margin-top: 50px;" v-if="lagss.length == 0">
                                <center>
                                <i class='bx bx-clipboard text-muted' style="font-size: 70px;"></i> <p class="text-muted">No Logs found.</p>
                                </center>
                            </div>
                            <ul class="verti-timeline list-unstyled" >
                                <li class="event-list" v-for="lag in lagss" v-bind:key="lag.id">
                                    <div class="event-timeline-dot">
                                        <i class="bx font-size-18" :class="{'text-primary bxs-info-circle ': lag.status == 'Operational','text-warning bxs-error-circle bx-flashing': lag.status == 'Maintenance', 'text-dark bxs-x-circle' : lag.status == 'Disposed'}"></i>
                                    </div>
                                    <div class="media">
                                        <div class="mr-3">
                                            <h5 class="font-size-14">{{lag.created_at}} <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                                        </div>
                                        <div class="media-body">
                                            <div>
                                                {{ (lag.status == "Operational") ? '' : lag.status }} ({{ lag.remarks }})
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: { asset: Object , stat: Object, user: String},
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                lagss: [],
                status: false
            }
        },

        methods : {
             makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    to: meta.to,
                    from: meta.from,
                    total: meta.total
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                let vm = this; 
                page_url = page_url || this.currentUrl + '/request/member/logs/'+this.asset.id;

                axios.get(page_url)
                .then(response => {
                    this.lagss = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            lags(id){
                this.fetch(this.currentUrl + '/request/member/logs/'+id);
            },

            update(val){
                this.lags(val.id);
                this.$emit('res',val)
            }
        }
    }
</script>
