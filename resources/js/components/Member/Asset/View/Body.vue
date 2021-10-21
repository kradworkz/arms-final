<template>
    <div class="card">
        <div class="card-body">
           <div class="row mb-3">
                <div class="col-xl-8 form-inline">
                    <ul class="list-inline user-chat-nav text-right mb-0">
                        <li class="list-inline-item mr-0">
                            <div @click="openModal(assetId,'Quantity','Add Quantity')" class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="New Asset">
                                <button class="btn nav-btn" type="button">
                                    <i class='bx bx-plus-circle'></i>
                                </button>
                            </div>
                        </li>
                        <li class="list-inline-item mr-0">
                            <div @click="setModal('Maintenance','Update Maintenance')" class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set Maintenance">
                                <button class="btn nav-btn" type="button">
                                    <i class="bx bx-cog"></i>
                                </button>
                            </div>
                        </li>
                        <li class="list-inline-item mr-3">
                            <div @click="setModal('Expiration','Update Expiration')" class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Set Expiration">
                                <button class="btn nav-btn" type="button">
                                    <i class='bx bx-time' ></i>
                                </button>
                            </div>
                        </li>
                    </ul>
                    <form class="float-sm-right form-inline">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                            <i class='bx bx-search-alt search-icon'></i>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-xl-4">
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
                            <button @click="fetchLists()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                <table class="table table-centered table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>  
                                <div class="custom-control custom-checkbox">
                                    <input id="customCheck_" type="checkbox" :value="'all'" @click='checkAll()' v-model='isCheckAll' class="custom-control-input"/>
                                    <label class="custom-control-label" for="customCheck_">&nbsp;</label>
                                </div>
                            </th>
                            <th class="text-center">Asset Code</th>
                            <th class="text-center">Tracker Code</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Acquired Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- :class="{'table-success':list.coordinates != 'n/a'} -->
                        <tr v-for="(list,index) in lists" v-bind:key="list.id">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input :id="'customCheck_'+list.id" type="checkbox" v-on:change='updateCheckall()' :value="list.id" v-model="selected" class="custom-control-input"/>
                                    <label class="custom-control-label" :for="'customCheck_'+list.id">&nbsp;</label>
                                </div>
                            </td>
                            <td class="text-center font-weight-bold">{{list.asset}}</td>
                            <td class="text-center">{{list.tracker}}</td>
                            <td class="text-center">
                                <span :class="'badge badge-'+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-center">{{list.created_at}}</td>
                            <td class="text-center">
                                <a v-if="list.status.name != 'Borrowed'" class="mr-2 text-warning font-size-16" @click="openModal(list.id,'Status','Update Status',list.status)"><i class='bx bx-edit-alt'></i></a>
                                <a v-else class="mr-2 text-warning font-size-16" @click="openModal(list.id,'Status','Update Status',list.status)"><i class='bx bxs-show'></i></a>
                                <a class="mr-2 text-danger font-size-16" @click="openModal(list.id,'Update','Update Asset',list)"><i v-bind:class="[(list.tracker == 'n/a' ? 'bx bxs-location-plus' : 'bx bxs-edit-location')]"></i></a>
                                <a @click="track(list.id,list.coordinates)" v-bind:class="[(list.coordinates != 'n/a' ? 'text-danger' : 'text-secondary')]" class="font-size-16"><i class='bx bx-current-location'></i></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <asset-add @status="result" ref="openmodal"></asset-add>
        <asset-set @status="result" ref="setmodal"></asset-set>
    </div>
</template>

<script>
    export default {
        props: ['assetId'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                lists: [],
                selected: [],
                isCheckAll: false
            }
        },
        
        created(){
            this.fetch();
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

            checkAll: function(){

                this.isCheckAll = !this.isCheckAll;
                this.selected = [];
                if(this.isCheckAll){ // Check all
                    for (var key in this.lists) {
                    this.selected.push(this.lists[key].id);
                    }
                }
            },

            updateCheckall: function(){
                if(this.selected.length == this.lists.length){
                    this.isCheckAll = true;
                }else{
                    this.isCheckAll = false;
                }
            },

            fetch(page_url){
                let vm = this; let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                page_url = page_url || this.currentUrl + '/request/member/lists/'+this.assetId+'/'+key;
                axios.get(page_url)
                .then(response => {
                    this.lists = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            track(id,coordinates){
                if(coordinates != 'n/a'){
                    this.$parent.$parent.trackMapId(id);
                }
            },

            result(status){
                (status) ? this.fetch() : Vue.$toast.error('<strong>Error, please contact administrator.</strong>', {position: 'bottom-right'});
            },

            openModal(id,type,text,data){
               this.$refs.openmodal.set(id,type,text,data);
            },

            setModal(type,text){
                let ids;
                ids = this.selected;
                this.$refs.setmodal.set(ids,type,text);
            }
        }
    }
</script>
