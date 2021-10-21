<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-6 form-inline">
                            <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-plus-medical'></i></button>
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                    <i class='bx bx-search-alt search-icon'></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                                <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
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
                                  <li class="list-inline-item d-non d-sm-inline-block">
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bxs-analyse'></i></span></button>                                 
                                        <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a @click="filter('','type')" class="dropdown-item">All</a>
                                            <a @click="filter(typ.id,'type')" class="dropdown-item" v-for="typ in types" v-bind:key="typ.id">{{typ.name}}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-inline-item d-non d-sm-inline-block">
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bx-filter'></i></span></button>                                 
                                        <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a @click="filter('','status')" class="dropdown-item">All</a>
                                            <a @click="filter(status.id,'status')" class="dropdown-item" v-for="status in statuses" v-bind:key="status.id">{{status.name}}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-inline-item d-non d-sm-inline-block">
                                    <button @click="fetch()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive" style="min-height: 230px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Station</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Data Logger</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(device,index) in devices" v-bind:key="device+index">
                                    <td>{{Number(pagination.count) + index }}</td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a class="text-dark">{{device.station}}</a></h5>
                                        <p class="text-muted mb-0">{{device.municipality.name}}, {{device.province.name}}</p>
                                    </td>
                                    <td class="text-center">{{device.type.name}}</td>
                                    <td class="text-center">{{device.datalogger}}</td>
                                    <td class="text-center">
                                     <span :class="'badge badge-'+device.status.color">{{device.status.name}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a @click="setCode(device)" class="font-size-16"><i class='bx bx-code-alt mr-2' ></i></a>
                                        <a @click="getData(device.id)" class="font-size-16"><i class='bx bxs-data mr-2' ></i></a>
                                        <a @click="track(device.coordinates)" v-bind:class="[(device.coordinates != 'n/a' ? 'text-danger' : 'text-secondary')]" class="font-size-16"><i class='bx bx-current-location'></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>

        <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <device-create @status="message" ref="create"></device-create>
        </div>

        <div class="modal fade exampleModal" id="setcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Device Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form @submit.prevent="create">
                        <div class="modal-body">
                            <div class="row" style="margin-right: 10px; margin-left: 10px;">
                                <div class="col-md-12 customerform" style="margin-top: 15px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Code: <span v-if="errors.code" class="haveerror">({{ errors.code[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="code" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                keyword: '',
                pagination: {},
                devices: [],
                statuses: [],
                status: '',
                types: [],
                type: '',
                editable: false,
                code: '',
                id: ''
            }
        },

        created(){
            this.fetch();
            this.fetchStatus();
            this.fetchType();
        },

        methods : {

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    total: meta.total,
                    count: meta.from
                };
                this.pagination = pagination;
            },

            fetchStatus(){
                axios.get(this.currentUrl + '/request/dropdowns/Status/Device')
                .then(response => {
                    this.statuses = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetchType(){
                axios.get(this.currentUrl + '/request/dropdowns/Device/-')
                .then(response => {
                    this.types = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetch(page_url){
                let vm = this; let key; let sta; let typ;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                (this.status != '' && this.status != null) ? sta = this.status : sta = '-';
                (this.type != '' && this.type != null) ? typ = this.type : typ = '-';
                page_url = page_url || this.currentUrl + '/request/admin/devices/'+key+'/'+sta+'/'+typ;

                axios.get(page_url)
                .then(response => {
                    this.devices = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            create(){
                axios.post(this.currentUrl + '/request/admin/device/store', {
                    id: this.id,
                    code: this.code,
                    editable: this.editable
                })
                .then(response => {
                    this.$emit('status', true);
                    this.editable = false;
                    this.id = ''; this.code = '';
                    $("#setcode").modal('hide');
                    this.fetch();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }else{
                        this.$emit('status', false);
                    }
                    
                });
            },


            filter(data,type){
                (type == 'status') ? this.status = data : this.type = data;
                this.fetch();
            },

            addnew(){
                $("#new").modal('show');
            },

            clear(){
                this.device = {};
            },

            track(coordinates){
                if(coordinates != 'n/a'){
                    this.$parent.trackMap(coordinates);
                }
            },

            getData(id){
                this.$parent.getData(id);
            },

            setCode(device){
                this.code = device.code;
                this.id = device.id;
                this.editable = true;
                $("#setcode").modal('show');
            },

            message(val){
                if(val){
                    if(this.editable == true){
                        let page_url = '/request/admin/devices/-?page=' + this.pagination.current_page;
                        this.fetch(page_url);
                    }else{
                        this.fetch();
                    }
                    $("#new").modal('hide');
                    this.editable = false;
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }
            }


        },  components: { Multiselect }
    }
</script>