<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-8 col-sm-8 form-inline">

                            <div data-trigger="hover" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter">
                                <button @click="searchFilter" type="button" class="btn btn-light waves-light waves-effect  mr-1">
                                <i class='bx bx-filter' ></i>
                                </button>
                            </div>
                             <div data-trigger="hover" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter BG">
                                <button @click="(color == false) ? color = true : color = false;" type="button" class="btn waves-light waves-effect mr-2" v-bind:class="(color == true) ? 'btn-dark' : 'btn-light'">
                                <i class='bx bxs-color-fill'></i> 
                                </button>
                            </div>
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                    <i class='bx bx-search-alt search-icon'></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-4 col-sm-4">
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
                                <li class="list-inline-item d-non d-sm-inline-block">
                                    <button @click="fetch()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                    <div v-if="filter == true" class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                 <multiselect  
                                    v-model="station" 
                                    @input="onChange()" 
                                    :show-labels="false"
                                    :options="stations" placeholder="Select Station" 
                                    label="name" track-by="id">
                                </multiselect>
                            </div>
                            <div class="col-md-4">
                                <multiselect  
                                    v-model="category" 
                                    @input="onChange()" 
                                    :show-labels="false"
                                    :options="categories" placeholder="Select Category" 
                                    label="name" track-by="id">
                                </multiselect>
                            </div>
                            <div class="col-md-4">
                                <multiselect  
                                    v-model="status" 
                                    @input="onChange()" 
                                    :show-labels="false"
                                    :options="statuses" placeholder="Select Status" 
                                    label="name" track-by="id">
                                </multiselect>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="table-responsive" data-simplebar style="max-height: calc(100vh - 340px); min-height: calc(100vh - 340px);">
                        <table class="table table-nowrap table-centered mb-0">
                            <thead style="position: sticky; top:0; background-color: white;">
                                <tr>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Asset</th>
                                    <th class="text-center">Availability</th>
                                    <th class="text-center">Station</th>
                                    <th class="text-center">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="asset in assets" v-bind:key="asset.id" @click="trselected = asset.id" :class="(color == true) ? {'table-success' : trselected == asset.id,'table-secondary' : asset.status.name == 'Disposed','table-danger' : asset.status.name == 'Maintenance','table-warning' : asset.status.name == 'Borrowed'} : {'table-success' : trselected == asset.id}">
                                    <td class="text-center">
                                        <span class="text-body font-weight-bold">#{{asset.asset_code}}</span>
                                    </td>
                                    <td class="text-center">{{asset.name}}</td>
                                    
                                    <td class="text-center">
                                        <div class="text-muted">
                                            <span class="badge font-size-11" v-bind:class="(asset.availability == 'Available' ? 'badge-soft-success' : 'badge-soft-danger')">{{asset.availability}}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{asset.location}}</td>
                                    <td class="text-center">
                                        <div class="text-muted">
                                            <span :class="'badge badge-'+asset.status.color+' font-size-11'">{{asset.status.name}}</span>
                                        </div>
                                    </td>
                                    <td >
                                        <button @click="view(asset)" type="button" class="btn btn-primary btn-sm btn-rounded">
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

        <div class="modal fade exampleModal" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <search-view :asset="asset" :user="user" :stat="stat" @res="update" ref="getlogs"></search-view>
        </div> 

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['user'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                categories: [],
                category: '',
                statuses: [],
                status: '',
                stations: [],
                station: '',
                assets: [],
                asset : {},
                stat: {},
                filter: false,
                trselected : '',
                color: false
            }
        },

        created(){
            this.fetch();
            this.fetchCategory();
            this.fetchStations();
            this.fetchStatus();
        },

        methods : {
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    total: meta.total,
                    to: meta.to,
                    from: meta.from
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                let vm = this; let key; let cat,stat,sta;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                (this.category != '' && this.category != null) ? cat = this.category.id : cat = '-';
                (this.station != '' && this.station != null) ? sta = this.station.id : sta = '-';
                (this.status != '' && this.status != null) ? stat = this.status.id : stat = '-';

                page_url = page_url || this.currentUrl + '/request/member/assets/search2/'+sta+'/'+cat+'/'+stat+'/'+key

                axios.get(page_url)
                .then(response => {
                    this.assets = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            fetchCategory(){
                axios.get(this.currentUrl + '/request/dropdowns/category/-')
                .then(response => {
                    this.categories = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetchStatus(){
                axios.get(this.currentUrl + '/request/dropdowns/status/asset')
                .then(response => {
                    this.statuses = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            fetchStations(){
                axios.get(this.currentUrl + '/request/member/locations')
                .then(response => {
                    this.stations = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChange(){
                this.fetch();
            },

            searchFilter(){
                if(this.filter == true){
                    this.filter = false;
                    // this.status = '';
                    // this.category = '';
                    // this.station = '';
                    // this.fetch();
                }else{
                    this.filter = true;
                }
            },

            view(asset){
                this.asset = asset;
                this.stat = asset.status;
                $("#view").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                this.$refs.getlogs.lags(this.asset.id);
            },

            update(val){
                this.asset = val;
                this.stat = val.status;
                var index = this.assets.map(x => {
                    return x.id;
                }).indexOf(val.id);
                this.assets[index] = val;
            }

        }, components: { Multiselect}
    }
</script>